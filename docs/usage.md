# Usage Guide

This guide explains how to use the Manta Contact Form package.

## Managing Contact Forms

The module provides full CRUD functionality for contact forms via the Manta CMS:

- **List**: Overview of all contact forms
- **Create**: Add new contact form
- **Edit**: Modify existing contact form
- **View**: View contact form details
- **Files**: Upload and manage attachments
- **Settings**: Module-specific configuration

## Managing Submissions

The same applies to contact form submissions:

- Complete contact details from visitors
- Form-specific information
- File management for attachments
- IP tracking for security
- Automatic email notifications

## Programmatic Usage

### Creating Contact Forms

```php
use Darvis\Mantacontact\Models\contact;

// Create new contact form
$contactForm = contact::create([
    'title' => 'General Contact Form',
    'subtitle' => 'Get in touch with us',
    'content' => 'Please fill out the form below...',
    'data' => ['required_fields' => ['name', 'email', 'message']]
]);
```

### Handling Submissions

```php
use Darvis\Mantacontact\Models\contactSubmission;

// Add submission
$submission = contactSubmission::create([
    'firstname' => 'John',
    'lastname' => 'Doe',
    'email' => 'john@example.com',
    'subject' => 'General Inquiry',
    'comment' => 'I would like more information about...'
]);
```

## Frontend Integration

For frontend contact forms, you can use the submission model directly:

```php
// In your controller
use Darvis\Mantacontact\Models\contactSubmission;
use Illuminate\Http\Request;

public function store(Request $request)
{
    $validated = $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'comment' => 'required|string',
    ]);

    contactSubmission::create($validated);
    
    return response()->json(['message' => 'Message sent successfully']);
}
```

### Frontend Form Example

```html
<form action="/api/contact" method="POST">
    @csrf
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" required>
        </div>
        <div>
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" required>
        </div>
    </div>
    
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    
    <div>
        <label for="subject">Subject</label>
        <input type="text" name="subject" id="subject" required>
    </div>
    
    <div>
        <label for="comment">Message</label>
        <textarea name="comment" id="comment" rows="5" required></textarea>
    </div>
    
    <button type="submit">Send Message</button>
</form>
```

## Admin Interface

### Accessing the Admin

1. Log in to your Manta CMS admin panel
2. Navigate to the Contact section
3. Use the interface to manage forms and submissions

### Available Routes

All admin routes are protected with staff middleware:

#### Contact Form Management Routes
- `GET /contact` - Contact forms overview
- `GET /contact/create` - Create new contact form
- `GET /contact/{id}` - View contact form details
- `GET /contact/{id}/edit` - Edit contact form
- `GET /contact/{id}/files` - File management
- `GET /contact/settings` - Module settings

## Email Notifications

The package automatically sends email notifications when new submissions are received. Configure email settings in the [configuration file](configuration.md).

## File Uploads

The package supports file uploads for contact form submissions. Files are managed through the Manta CMS file management system.

## Next Steps

- [Understand the database schema](database.md)
- [View troubleshooting guide](troubleshooting.md)
- [Learn about API endpoints](api.md)
