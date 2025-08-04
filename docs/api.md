# API Documentation

This document describes the API endpoints and programmatic usage of the Manta Contact Form package.

## Models

### Contact Model

The main model for contact form submissions.

```php
use Darvis\Mantacontact\Models\contact;

// Create a new contact
$contact = contact::create([
    'firstname' => 'John',
    'lastname' => 'Doe',
    'email' => 'john@example.com',
    'subject' => 'General Inquiry',
    'comment' => 'I would like more information...'
]);

// Find contacts
$contact = contact::find(1);
$contacts = contact::where('active', true)->get();
$recentContacts = contact::latest()->take(10)->get();

// Update contact
$contact->update([
    'comment_internal' => 'Follow up required'
]);

// Soft delete
$contact->delete();
```

## Available Methods

### Query Scopes

```php
// Active contacts only
contact::active()->get();

// By company
contact::where('company_id', 1)->get();

// Recent submissions
contact::recent()->get();

// Search by email
contact::where('email', 'like', '%@example.com')->get();
```

### Relationships

```php
// Get contact with files (if using uploads)
$contact = contact::with('uploads')->find(1);

// Get contact creator
$contact = contact::with('creator')->find(1);
```

## REST API Endpoints

### Frontend API Routes

Create these routes in your application for frontend integration:

```php
// routes/api.php
use App\Http\Controllers\ContactController;

Route::post('/contact', [ContactController::class, 'store']);
Route::get('/contact-forms', [ContactController::class, 'forms']);
```

### Example Controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Darvis\Mantacontact\Models\contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Store a new contact submission
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'comment' => 'required|string',
            'newsletters' => 'boolean',
        ]);

        // Add IP address and timestamp
        $validated['ip'] = $request->ip();
        $validated['active'] = true;

        $contact = contact::create($validated);

        return response()->json([
            'message' => 'Contact form submitted successfully',
            'id' => $contact->id
        ], 201);
    }

    /**
     * Get available contact forms
     */
    public function forms(): JsonResponse
    {
        $forms = contact::active()
            ->select('id', 'title', 'subtitle', 'content')
            ->get();

        return response()->json($forms);
    }

    /**
     * Get contact by ID
     */
    public function show(int $id): JsonResponse
    {
        $contact = contact::findOrFail($id);

        return response()->json($contact);
    }
}
```

## Validation Rules

### Standard Validation

```php
$rules = [
    'firstname' => 'required|string|max:255',
    'lastname' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'nullable|string|max:255',
    'company' => 'nullable|string|max:255',
    'subject' => 'required|string|max:255',
    'comment' => 'required|string|max:1000',
    'newsletters' => 'boolean',
];
```

### Extended Validation

```php
$rules = [
    // Basic fields
    'firstname' => 'required|string|max:255',
    'lastname' => 'required|string|max:255',
    'email' => 'required|email|max:255|unique:manta_contacts,email',

    // Optional fields
    'phone' => 'nullable|string|max:255',
    'company' => 'nullable|string|max:255',
    'address' => 'nullable|string|max:255',
    'zipcode' => 'nullable|string|max:10',
    'city' => 'nullable|string|max:255',
    'country' => 'nullable|string|max:255',

    // Message fields
    'subject' => 'required|string|max:255',
    'comment' => 'required|string|max:2000',

    // Preferences
    'newsletters' => 'boolean',

    // Custom fields
    'option_1' => 'nullable|string|max:1000',
    'option_2' => 'nullable|string|max:1000',
];
```

## Events

### Model Events

```php
use Darvis\Mantacontact\Models\contact;

// Listen for contact creation
contact::created(function ($contact) {
    // Send notification email
    Mail::to(config('manta-contact.email.default_receivers'))
        ->send(new ContactSubmissionMail($contact));
});

// Listen for contact updates
contact::updated(function ($contact) {
    // Log the update
    Log::info('Contact updated', ['id' => $contact->id]);
});
```

## Custom Fields

### Using Option Fields

```php
// Store custom data in option fields
$contact = contact::create([
    'firstname' => 'John',
    'lastname' => 'Doe',
    'email' => 'john@example.com',
    'subject' => 'Product Inquiry',
    'comment' => 'I need more information',
    'option_1' => 'Product A',
    'option_2' => 'Urgent',
    'option_3' => json_encode(['source' => 'website', 'campaign' => 'summer2024'])
]);

// Retrieve custom data
$productInterest = $contact->option_1;
$priority = $contact->option_2;
$metadata = json_decode($contact->option_3, true);
```

### Using JSON Data Field

```php
// Store complex data in JSON field
$contact = contact::create([
    'firstname' => 'John',
    'lastname' => 'Doe',
    'email' => 'john@example.com',
    'subject' => 'Support Request',
    'comment' => 'I need help with...',
    'data' => json_encode([
        'source' => 'contact_form',
        'utm_campaign' => 'spring_promotion',
        'user_agent' => request()->userAgent(),
        'referrer' => request()->header('referer'),
        'custom_fields' => [
            'department' => 'sales',
            'priority' => 'high'
        ]
    ])
]);

// Query JSON data
$salesContacts = contact::whereJsonContains('data->custom_fields->department', 'sales')->get();
```

## Bulk Operations

### Bulk Insert

```php
$contacts = [
    [
        'firstname' => 'John',
        'lastname' => 'Doe',
        'email' => 'john@example.com',
        'subject' => 'Inquiry 1',
        'comment' => 'Message 1',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'firstname' => 'Jane',
        'lastname' => 'Smith',
        'email' => 'jane@example.com',
        'subject' => 'Inquiry 2',
        'comment' => 'Message 2',
        'created_at' => now(),
        'updated_at' => now(),
    ]
];

contact::insert($contacts);
```

### Bulk Update

```php
// Mark all contacts from specific company as processed
contact::where('company', 'Example Corp')
    ->update(['comment_internal' => 'Processed by sales team']);
```

## Export Functions

### CSV Export

```php
use League\Csv\Writer;

public function exportContacts()
{
    $contacts = contact::select([
        'firstname', 'lastname', 'email', 'phone',
        'company', 'subject', 'comment', 'created_at'
    ])->get();

    $csv = Writer::createFromString('');
    $csv->insertOne([
        'First Name', 'Last Name', 'Email', 'Phone',
        'Company', 'Subject', 'Message', 'Date'
    ]);

    foreach ($contacts as $contact) {
        $csv->insertOne([
            $contact->firstname,
            $contact->lastname,
            $contact->email,
            $contact->phone,
            $contact->company,
            $contact->subject,
            $contact->comment,
            $contact->created_at->format('Y-m-d H:i:s')
        ]);
    }

    return response($csv->toString())
        ->header('Content-Type', 'text/csv')
        ->header('Content-Disposition', 'attachment; filename="contacts.csv"');
}
```

## Security Considerations

### Rate Limiting

```php
// In routes/api.php
Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/contact', [ContactController::class, 'store']);
});
```

### Input Sanitization

```php
use Illuminate\Support\Str;

$validated['comment'] = Str::limit(strip_tags($validated['comment']), 2000);
$validated['subject'] = strip_tags($validated['subject']);
```

### CSRF Protection

```php
// For web forms
<form method="POST" action="/contact">
    @csrf
    <!-- form fields -->
</form>
```

## Next Steps

- [Learn about usage](usage.md)
- [Understand configuration](configuration.md)
- [View troubleshooting guide](troubleshooting.md)
