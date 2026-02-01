# Firebase Storage Integration Guide

## Setup Complete ✓

Firebase Storage has been integrated into your Laravel application. Images will now be uploaded to Firebase Storage and URLs will be stored in your database.

## Configuration

### 1. Firebase Credentials
The Firebase service account credentials are located at:
```
storage/app/firebase.json
```

### 2. Environment Variables
Added to `.env`:
```
FIREBASE_STORAGE_BUCKET=gs://ssp-b7455.firebasestorage.app
```

### 3. Service Configuration
Firebase settings are configured in `config/services.php`:
```php
'firebase' => [
    'credentials' => storage_path('app/firebase.json'),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', 'gs://ssp-b7455.firebasestorage.app'),
],
```

## How It Works

### FirebaseStorageService
A dedicated service class (`App\Services\FirebaseStorageService`) handles all Firebase Storage operations:

#### Available Methods:

1. **uploadImage($file, $folder)**
   - Uploads an image to Firebase Storage
   - Returns the public URL
   - Example: `$url = $firebaseStorage->uploadImage($request->file('image'), 'products');`

2. **deleteImage($fileUrl)**
   - Deletes an image from Firebase Storage
   - Example: `$firebaseStorage->deleteImage($product->image_url);`

3. **uploadMultipleImages($files, $folder)**
   - Upload multiple images at once
   - Returns array of URLs
   - Example: `$urls = $firebaseStorage->uploadMultipleImages($files, 'gallery');`

4. **getPublicUrl($filePath)**
   - Gets the public URL for a file path
   - Example: `$url = $firebaseStorage->getPublicUrl('products/image.jpg');`

## Updated Controllers

### Admin\ProductController
- Product image uploads now use Firebase Storage
- Old images are deleted from Firebase when updated
- Supports create, update, and delete operations

### Api\ProductController
- API endpoints now support Firebase image uploads
- Validates image files (max 10MB)
- Handles multipart/form-data requests

## Usage Examples

### In Controllers
```php
use App\Services\FirebaseStorageService;

class YourController extends Controller
{
    protected $firebaseStorage;

    public function __construct(FirebaseStorageService $firebaseStorage)
    {
        $this->firebaseStorage = $firebaseStorage;
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $imageUrl = $this->firebaseStorage->uploadImage(
                $request->file('image'), 
                'your-folder-name'
            );
            
            // Store $imageUrl in database
            YourModel::create([
                'image_url' => $imageUrl,
                // ... other fields
            ]);
        }
    }
}
```

### In Blade Views
Display the Firebase URL just like any other image:
```blade
<img src="{{ $product->image_url }}" alt="{{ $product->name }}">
```

## API Usage

### Upload via API (multipart/form-data)

**POST /api/products**
```bash
curl -X POST http://your-app.test/api/products \
  -F "name=Product Name" \
  -F "price=99.99" \
  -F "stock_quantity=100" \
  -F "image=@/path/to/image.jpg"
```

**Response:**
```json
{
  "success": true,
  "message": "Product created successfully",
  "data": {
    "id": 1,
    "name": "Product Name",
    "image_url": "https://firebasestorage.googleapis.com/v0/b/ssp-b7455.firebasestorage.app/o/products%2F1234567890_abc123.jpg?alt=media",
    ...
  }
}
```

## URL Format
Firebase Storage URLs follow this pattern:
```
https://firebasestorage.googleapis.com/v0/b/{bucket-name}/o/{encoded-file-path}?alt=media
```

Example:
```
https://firebasestorage.googleapis.com/v0/b/ssp-b7455.firebasestorage.app/o/products%2F1705012345_abc123xyz.jpg?alt=media
```

## Storage Structure
Images are organized in folders:
- `products/` - Product images
- You can create additional folders as needed (e.g., `categories/`, `banners/`, etc.)

## Security & Permissions
- All uploaded images are publicly accessible
- Firebase Storage Rules should be configured in Firebase Console
- Service account has admin access via firebase.json

## Testing

To test the integration:

1. **Via Web Interface:**
   - Go to admin product create/edit page
   - Upload an image
   - Check the database - `image_url` should contain Firebase URL

2. **Via API:**
   - Use Postman or curl to send multipart/form-data
   - Include image file in the request
   - Verify response contains Firebase URL

## Troubleshooting

### If uploads fail:
1. Check `storage/logs/laravel.log` for errors
2. Verify `firebase.json` credentials are correct
3. Ensure Firebase Storage bucket exists in Firebase Console
4. Verify bucket permissions allow public read access

### Common Issues:
- **403 Forbidden**: Check Firebase Storage Rules
- **404 Not Found**: Verify bucket name in config
- **500 Server Error**: Check Laravel logs and Firebase credentials

## Next Steps

You can extend this integration to:
1. Upload multiple images per product
2. Add image galleries
3. Upload user avatars
4. Store documents (PDFs, etc.)
5. Add image optimization before upload
6. Implement signed URLs for private files

## Firebase Console
Manage your storage at:
https://console.firebase.google.com/project/ssp-b7455/storage

---

**Storage Bucket:** `gs://ssp-b7455.firebasestorage.app`
**Status:** ✅ Ready to use
