<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 8/7/2018
 * Time: 10:59 AM
 */

namespace SecureMessaging\Attachment;


use JsonSchema\Exception\InvalidConfigException;
use SecureMessaging\Client\GuzzleClientSingleton;
use SecureMessaging\Client\HttpRequestHandler;
use SecureMessaging\Models\Request\PreCreateAttachmentRequest;
use SecureMessaging\SavedMessage;
use SecureMessaging\SecureMessage;

class AttachmentManager
{

    private $client;
    private $message;

    private $attachmentList = [];
    private $postPreCreateAttachmentResponse;

    private $attachmentsHaveBeenPreCreated = false;

    public function __construct(SecureMessage $message, HttpRequestHandler $client){
        $this->client = $client;
        $this->message = $message;
    }

    public static function instantiateWithSavedMessage(SavedMessage $message, HttpRequestHandler $client){
        return new AttachmentManager($message->message, $client);
    }

    public function closeAllFilePointersToAttachments(){
        foreach($this->attachmentList as $attachment){
            fclose($attachment["filePointer"]);
        }
    }

    public function addAttachmentFile($fp, $fileName){
        if($this->attachmentsHaveBeenPreCreated()){
            return false;
        }else{
            $this->attachmentList[] = ["filePointer" => $fp, "fileName" => $fileName];
            return true;
        }
    }

    public function getAllPreCreatedAttachments(){
        return $this->postPreCreateAttachmentResponse["attachmentPlaceholders"];
    }

    public function deleteAttachmentFileMatchingGuid($attachmentGuid){

        if(!$this->attachmentsHaveBeenPreCreated()){
            throw new InvalidConfigException("Attachments Must all Be PreCreated Before Deletion By AttachmentGuid Can Be Used");
        }

        foreach($this->postPreCreateAttachmentResponse["attachmentPlaceholders"] as $attachmentPlaceholder){

            //find the attachment placeholder entry with the guid
            if($attachmentPlaceholder["attachmentGuid"] == $attachmentGuid){

                //now try and find the attachmentList item with the same file name
                foreach($this->attachmentList as $attachment){
                    if($attachment["fileName"] == $attachmentPlaceholder["fileName"]){

                        //then we have a reference to the fp, so call the method to delete the fp
                        return $this->deleteAttachmentFile($attachment["filePointer"]);
                    }
                }
            }
        }

        return false;
    }

    public function deleteAttachmentFile($fp){

        $attachmentBeingDeleted = null;
        $attachmentListIndex = 0;

        for($i = 0; $i < count($this->attachmentList); $i++){
            if($this->attachmentList[$i]["filePointer"] == $fp){

                $attachmentBeingDeleted = $this->attachmentList[$i];
                $attachmentListIndex = $i;
                break;
            }
        }

        if($attachmentBeingDeleted == null){
            return false;
        }

        if($this->attachmentsHaveBeenPreCreated()){
            //make an API call to delete this
            $url = "/messages/" . $this->message->getMessageGuid() . "/attachments/" . $attachmentBeingDeleted["attachmentGuid"];
            $responseHandler = $this->client->delete($url);

            if($responseHandler->getStatusCode() != 200){

                return false;
            }
        }
        //else we don't need to do anything else
        unset($this->attachmentList[$attachmentListIndex]);
        return true;
    }

    public function attachmentsHaveBeenPreCreated(){
        return $this->attachmentsHaveBeenPreCreated;
    }

    public function preCreateAllAttachments(){

        $attachmentPlaceholders = [];
        foreach($this->attachmentList as $attachment){

            $fstat = fstat($attachment["filePointer"]);
            $placeholder = ["fileName" => $attachment["fileName"], "totalBytesLength" => $fstat["size"]];

            $attachmentPlaceholders[] = $placeholder;
        }

        $preCreateAttachmentRequest = new PreCreateAttachmentRequest();
        $preCreateAttachmentRequest->attachmentPlaceholders = $attachmentPlaceholders;
        $preCreateAttachmentRequest->messageGuid = $this->message->getMessageGuid();

        $responseHandler = $this->client->post("/attachments/precreate", $preCreateAttachmentRequest);

        $this->postPreCreateAttachmentResponse = $responseHandler->getJsonBody();

        //sync all of the attachmentGuids to the local list
        foreach($this->postPreCreateAttachmentResponse["attachmentPlaceholders"] as $attachmentPlaceholder){

            for($i = 0; $i < count($this->attachmentList); $i++){
                if($this->attachmentList[$i]["fileName"] == $attachmentPlaceholder["fileName"]){
                    $this->attachmentList[$i]["attachmentGuid"] = $attachmentPlaceholder["attachmentGuid"];
                    break;
                }
            }
        }

        $this->attachmentsHaveBeenPreCreated = true;

    }

    public function uploadAllAttachments(){
        foreach($this->postPreCreateAttachmentResponse["attachmentPlaceholders"] as $attachmentPlaceholder){

            foreach($this->attachmentList as $preCreatedAttachment){
                if($preCreatedAttachment["fileName"] == $attachmentPlaceholder["fileName"]){
                    $this->uploadAttachment($attachmentPlaceholder, $preCreatedAttachment);
                }
            }
        }
    }

    private function uploadAttachment($attachmnetPlaceholder, $attachmentListFile){

        foreach($attachmnetPlaceholder["chunks"] as $attachmentChunk){
            $this->uploadAttachmentChunk($attachmentChunk, $attachmentListFile);
        }
    }

    private function uploadAttachmentChunk($attachmentChunk, $attachmentListFile){

        $filePointer = $attachmentListFile['filePointer'];
        $fileName = $attachmentListFile['fileName'];

        $byteStartIndex = $attachmentChunk['byteStartIndex'];
        $byteEndIndex = $attachmentChunk['byteEndIndex'];
        $uploadUri = $attachmentChunk['uploadUri'];

        fseek($filePointer, 0);
        fseek($filePointer, $byteStartIndex);

        $contents = fread($filePointer, ($byteEndIndex - $byteStartIndex));
        $responseHandler = $this->client->multipart("POST", $uploadUri, $fileName, $contents);

    }


}