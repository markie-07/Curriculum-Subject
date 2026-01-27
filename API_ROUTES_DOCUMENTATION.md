# API Routes Documentation

## Overview
All data-related routes are accessible via the `/api/` prefix for proper API integration. These routes support both internal web application access and external API integration.

## Architecture

### Routes in `web.php` (with `/api` prefix)
All data-related API routes are defined in `web.php` under a `/api` prefix group. This ensures they have access to:
- **Session middleware** - For web-based authentication
- **CSRF protection** - For security
- **Activity logging** - For tracking user actions

These routes are accessible at `/api/...` and work seamlessly with your web frontend.

### Routes in `api.php`
The `api.php` file is reserved for external API access using token-based authentication (Laravel Sanctum). This is for future external integrations.

## API Endpoints Available

### Authentication
All API routes require authentication and support:
- **Session-based authentication** (for web frontend) - Uses cookies ✅
- **CSRF token** - Required for POST/PUT/DELETE requests from web frontend
- **Activity logging** - All actions are logged automatically

**For Web Frontend:**
- No special configuration needed
- Uses existing session cookies
- CSRF token automatically included in requests

### Curriculum Routes
- `GET /api/curriculums` - Get all curriculums
- `POST /api/curriculums` - Create a new curriculum
- `GET /api/curriculums/{id}` - Get curriculum data
- `PUT /api/curriculums/{id}` - Update curriculum
- `DELETE /api/curriculums/{id}` - Delete curriculum
- `POST /api/curriculums/save` - Save subjects to curriculum
- `POST /api/curriculum/remove-subject` - Remove subject from curriculum
- `GET /api/curriculum/{id}/details` - Get curriculum details for export
- `GET /api/curriculums/{id}/subjects` - Get curriculum subjects
- `POST /api/curriculums/{id}/add-subjects` - Add subjects to curriculum
- `POST /api/curriculums/{id}/approve` - Approve curriculum
- `POST /api/curriculums/{id}/reject` - Reject curriculum
- `POST /api/curriculums/{id}/restore` - Restore curriculum
- `GET /api/curriculum/{id}/export-pdf` - Export curriculum as PDF

### Subject Routes
- `GET /api/subjects` - Get all subjects
- `POST /api/subjects` - Create a new subject
- `GET /api/subjects/{id}` - Get subject details
- `GET /api/subjects/{id}/versions` - Get subject version history
- `PUT /api/subjects/{id}` - Update subject
- `DELETE /api/subjects/{subject}` - Delete subject
- `GET /api/subjects/{subjectId}/export-pdf` - Export subject as PDF

### Prerequisite Routes
- `GET /api/prerequisites/{curriculum}` - Fetch prerequisite data
- `POST /api/prerequisites` - Store prerequisites

### Grade Routes
- `POST /api/grades` - Store grades
- `GET /api/grades/{subjectId}` - Get grades for subject
- `GET /api/grades/{subjectId}/version-history` - Get grade version history

### Curriculum Grade Routes
- `GET /api/curriculum-grades` - Get all curriculum grades
- `POST /api/curriculum-grades` - Store curriculum grades
- `GET /api/curriculum-grades/{curriculumId}` - Get curriculum grades

### Equivalency Tool Routes
- `GET /api/equivalencies` - Get all equivalencies
- `POST /api/equivalencies` - Create equivalency
- `PATCH /api/equivalencies/{equivalency}` - Update equivalency
- `DELETE /api/equivalencies/{equivalency}` - Delete equivalency

### Global Search Routes
- `POST /api/global-search` - Perform global search
- `GET /api/quick-search/{type}` - Quick search by type

### Compliance Links Routes
- `GET /api/compliance-links` - Get all compliance links
- `GET /api/compliance-links/categories` - Get compliance link categories
- `POST /api/compliance-links` - Create compliance link
- `PUT /api/compliance-links/{id}` - Update compliance link
- `DELETE /api/compliance-links/{id}` - Delete compliance link

### Dashboard Routes
- `GET /api/dashboard/export-data` - Get export data
- `GET /api/dashboard/recent-activities` - Get recent activities (filtered)
- `GET /api/dashboard/module-usage` - Get module usage data

### Curriculum History Routes
- `GET /api/curriculum-history/{curriculumId}/versions` - Get curriculum versions
- `GET /api/curriculum-history/{curriculumId}/versions/{versionId}` - Get version details
- `POST /api/curriculum-history/{curriculumId}/snapshot` - Create snapshot
- `GET /api/curriculum-history/{curriculumId}/compare/{version1Id}/{version2Id}` - Compare versions

### Syllabus Extraction Routes
- `POST /api/extract-syllabus` - Extract DepEd syllabus from PDF
- `POST /api/extract-ched-syllabus` - Extract CHED syllabus from PDF

### Description Similarity Check
- `POST /api/check-description-similarity` - Check description similarity

## What Remains in `web.php`

The following routes remain in `web.php` as they are web-specific and require session-based authentication:

1. **Authentication Routes** - Login, OTP verification, logout
2. **Profile Routes** - User profile management
3. **Notification Routes** - User notifications
4. **Curriculum Export Tool** - Web interface for curriculum export
5. **Admin View Routes** - All admin page views (curriculum builder, subject mapping, etc.)
6. **Employee Management Routes** - Employee CRUD operations (admin only)
7. **Debug Routes** - Development/testing routes

## How to Use the API

### For External Integration

1. **Authenticate**: Use Laravel Sanctum to authenticate your requests
   - You'll need to obtain an API token for your user
   
2. **Make Requests**: Include the token in your requests
   ```
   Authorization: Bearer {your-token}
   ```

3. **Base URL**: All API routes are prefixed with `/api/`
   - Example: `http://your-domain.com/api/curriculums`

### For Internal JavaScript/AJAX Calls

Your existing frontend JavaScript should continue to work as-is, since the routes are still accessible at the same paths (e.g., `/api/curriculums`). The only difference is that they now use Sanctum authentication instead of session-based authentication.

## Important Notes

1. **Authentication**: All API routes require authentication via Laravel Sanctum
2. **CSRF Protection**: API routes using Sanctum don't require CSRF tokens
3. **Response Format**: All responses are in JSON format
4. **Error Handling**: Standard HTTP status codes are used (200, 201, 400, 401, 404, 500, etc.)

## Migration Impact

- **Frontend**: Your existing frontend code should continue to work without changes
- **External APIs**: Can now integrate with your system using standard API authentication
- **Testing**: You can now test API endpoints using tools like Postman or curl
- **Documentation**: Consider using tools like Swagger/OpenAPI for API documentation

## Next Steps

1. **Set up Sanctum tokens** for users who need API access
2. **Test all endpoints** to ensure they work correctly
3. **Update any external integrations** to use the new authentication method
4. **Consider rate limiting** for API endpoints to prevent abuse
5. **Add API documentation** for external developers
