<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function showForm()
    {
        return view('file.EncryptForm');
    }

    public function processFile(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'operation' => 'required|in:encrypt,decrypt',
            'output_name' => 'required',
            'output_path' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('file.form')
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        $operation = $request->input('operation');
        $outputName = $request->input('output_name');
        $outputPath = $request->input('output_path');
        $key = 'AnyKey_1234454432#@_asdsadsa_432423$_23123!@#!@_312312'; 

       $fileDetails = [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'extension' => $file->getClientOriginalExtension(),
        ];

        $outputFilePath ="{$outputPath}/{$outputName}";

        if ($operation === 'encrypt') {
            $this->encryptFile($file->getRealPath(), $outputFilePath, $key);
        } elseif ($operation === 'decrypt') {
            $this->decryptFile($file->getRealPath(), $outputFilePath, $key);
        }

        return view('file.result', compact('fileDetails', 'operation', 'outputFilePath'));
    }

private function encryptFile($inputFilePath, $outputFilePath, $key)
{

    error_log("----------------------- encrypt started ----------------");

    $inputFile = fopen($inputFilePath, 'rb');
    if (!$inputFile) {
        throw new \RuntimeException("Unable to open input file for reading: $inputFilePath");
    }

    $outputFile = fopen($outputFilePath, 'wb');
    if (!$outputFile) {
        fclose($inputFile);
        throw new \RuntimeException("Unable to open output file for writing: $outputFilePath");
    }

  
  $readChenckSize = 1024 * 30;

    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    $data = fread($inputFile, $readChenckSize);
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

    if($encryptedData === false){
        fclose($inputFile);
        fclose($outputFile);
        throw new \RuntimeException("Error during encryption");
    }
    //put chenck size for decryption
    fwrite($outputFile, strlen($encryptedData)."\n");
    fwrite($outputFile, $iv);
    fwrite($outputFile, $encryptedData);

    $isEncryptionSuccessful = true;

    while (!feof($inputFile)) {
        $data = fread($inputFile, $readChenckSize);
        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        fwrite($outputFile, $encryptedData);
        if ($encryptedData === false) {
            $isEncryptionSuccessful = false;
            break;
        }
    }
    fclose($inputFile);
    fclose($outputFile);
    if (!$isEncryptionSuccessful) {
        throw new \RuntimeException("Error during encryption");
    }
}


private function decryptFile($inputFilePath, $outputFilePath, $key)
{
    $inputFile = fopen($inputFilePath, 'rb');
    if (!$inputFile) {
        throw new \RuntimeException("Unable to open input file for reading: $inputFilePath");
    }

    $outputFile = fopen($outputFilePath, 'wb');
    if (!$outputFile) {
        fclose($inputFile);
        throw new \RuntimeException("Unable to open output file for writing: $outputFilePath");
    }

    $chenckSize = fgets($inputFile);

    fseek($inputFile, strlen($chenckSize));

    $decryptChenckSize = (int)$chenckSize;
    
    $iv = fread($inputFile,openssl_cipher_iv_length('aes-256-cbc'));

    $isDecryptionSuccessful = true;

    while (!feof($inputFile)) {
        $data = fread($inputFile, $decryptChenckSize);
        $decryptedData = openssl_decrypt($data, 'aes-256-cbc', $key, 0, $iv);

        fwrite($outputFile, $decryptedData);

        if ($decryptedData === false) {
            $isDecryptionSuccessful = false;
            break;
        }
    }
    fclose($inputFile);
    fclose($outputFile);

    if (!$isDecryptionSuccessful) {
        throw new \RuntimeException("Error during decryption");
    }
}

}
