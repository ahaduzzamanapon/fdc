<?php
echo "Current File: " . __FILE__ . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "App Path: " . base64_encode(realpath(__DIR__ . '/..'));
