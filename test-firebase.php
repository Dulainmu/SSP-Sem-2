<?php

// Test Firebase Configuration
// Run with: php test-firebase.php

require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

try {
    echo "Testing Firebase Configuration...\n\n";
    
    $credentialsPath = __DIR__ . '/storage/app/firebase.json';
    $storageBucket = 'gs://ssp-b7455.firebasestorage.app';
    
    echo "1. Checking credentials file...\n";
    if (file_exists($credentialsPath)) {
        echo "   ✓ Credentials file exists: $credentialsPath\n";
        $credentials = json_decode(file_get_contents($credentialsPath), true);
        echo "   ✓ Project ID: " . ($credentials['project_id'] ?? 'N/A') . "\n";
    } else {
        echo "   ✗ Credentials file NOT found!\n";
        exit(1);
    }
    
    echo "\n2. Storage Bucket: $storageBucket\n";
    
    echo "\n3. Initializing Firebase...\n";
    $factory = (new Factory)
        ->withServiceAccount($credentialsPath)
        ->withDefaultStorageBucket($storageBucket);
    
    echo "   ✓ Factory created\n";
    
    $storage = $factory->createStorage();
    echo "   ✓ Storage service created\n";
    
    $bucket = $storage->getBucket();
    echo "   ✓ Bucket acquired\n";
    
    echo "   Bucket name: " . $bucket->name() . "\n";
    
    echo "\n✓ Firebase is configured correctly!\n\n";
    echo "You can now upload images through your admin panel.\n";
    
} catch (Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "\nFull error:\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
