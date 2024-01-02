# File Encryptor Application

## Overview

This solution addresses a task that requires users to choose a file from their computers, display file details on the screen, and perform encryption or decryption by selecting the output file name and location.

## Implementation

Using Laravel and PHP, I employed file system functions to read files, divided them into chunks, and initiated the encryption or decryption process. The chunk size was included in the encrypted file for efficient decryption, optimizing memory usage.

## Code Structure

Initially, the code is organized directly within the Laravel controller. To enhance maintainability and modularity, consider refactoring the encryption and decryption functions into utility classes. Create a utility class with the necessary methods, then inject an instance of this class into the controller. This approach adheres to best practices and improves code organization.

## How to Use

1. Clone the repository.
2. Set up your Laravel environment.
3. Run the application.

## Enhancements

Consider refactoring the code to improve readability and maintainability by adopting object-oriented principles. This includes creating utility classes and injecting them into the controller for a cleaner and more scalable structure.

## learning resources 

intro to AES algorthim :https://www.youtube.com/watch?v=Lt0nkqccEhc

streams in node.js how to devided files : https://www.youtube.com/watch?v=e5E8HHEYRNI&t=10514s 
