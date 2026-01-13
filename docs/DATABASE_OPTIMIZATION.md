# Database Connection Optimization Guide

## 🎯 Overview

This guide explains the database connection optimizations implemented to avoid hitting connection limits and improve performance.

## ⚠️ Problem

Remote database servers often have connection limits (e.g., 500 connections per hour). Excessive connections can cause:
- `SQLSTATE[HY000] [1226] User has exceeded the 'max_connections_per_hour' resource`
- Application downtime
- Slow performance

## ✅ Solutions Implemented

### 1. **Persistent Connections** (config/database.php)

Reuses existing database connections instead of creating new ones for each request.

```php
PDO::ATTR_PERSISTENT => env('DB_PERSISTENT', false)
```

**Benefits:**
- Reduces connection overhead
- Fewer new connections created
- Better performance

**When to use:**
- ✅ Production environment
- ❌ Development (can cause issues with connection pooling)

### 2. **Sticky Connections** (config/database.php)

Uses the same connection for both read and write operations.

```php
'sticky' => env('DB_STICKY', true)
```

**Benefits:**
- Maintains consistency
- Reduces connection switching
- Better transaction handling

### 3. **Connection Timeout** (config/database.php)

Fails fast if database is unavailable.

```php
PDO::ATTR_TIMEOUT => env('DB_TIMEOUT', 5)
```

**Benefits:**
- Prevents hanging requests
- Faster error detection
- Better user experience

### 4. **Buffered Queries** (config/database.php)

Uses buffered queries to reduce memory usage.

```php
PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
```

**Benefits:**
- Lower memory consumption
- Better performance for large result sets

### 5. **Local Development Database**

Use XAMPP's local MySQL for development to avoid connection limits entirely.

**Setup:**
1. Start XAMPP MySQL
2. Create database: `CREATE DATABASE curriculumsubject;`
3. Update `.env`:
   ```env
   DB_HOST=127.0.0.1
   DB_DATABASE=curriculumsubject
   DB_USERNAME=root
   DB_PASSWORD=
   ```

**Benefits:**
- ✅ No connection limits
- ✅ Faster queries
- ✅ Work offline
- ✅ Unlimited testing

## 🛠️ Configuration

### Environment Variables (.env)

```env
# Persistent Connections (false for dev, true for production)
DB_PERSISTENT=false

# Connection Timeout (seconds)
DB_TIMEOUT=5

# Sticky Connections (recommended: true)
DB_STICKY=true
```

### Switching Between Environments

**Local Development:**
```env
DB_HOST=127.0.0.1
DB_DATABASE=curriculumsubject
DB_USERNAME=root
DB_PASSWORD=
DB_PERSISTENT=false
```

**Production:**
```env
DB_HOST=153.92.15.81
DB_DATABASE=u514031374_csm3
DB_USERNAME=u514031374_csm3
DB_PASSWORD=csm3P@55w0rd
DB_PERSISTENT=true  # Enable for production
```

## 📊 Monitoring

### Check Database Connection

```bash
php artisan db:monitor
```

Shows:
- Current configuration
- Connection test
- Response time

### View Connection Statistics

```bash
php artisan db:monitor --stats
```

Shows:
- Active connections
- Total connections
- Connection errors
- Table count

### Quick Connection Check

```bash
php artisan db:monitor --check
```

## 🚀 Best Practices

### DO:
- ✅ Use local database for development
- ✅ Enable persistent connections in production
- ✅ Close database tools when not in use
- ✅ Run migrations once, verify once
- ✅ Use `php artisan migrate --pretend` to preview
- ✅ Monitor connection usage with `php artisan db:monitor`

### DON'T:
- ❌ Run migrations repeatedly
- ❌ Keep multiple database tools open
- ❌ Use `tinker` for long-running queries
- ❌ Make excessive `information_schema` queries
- ❌ Leave SQLyog/phpMyAdmin connected when idle

## 🔧 Troubleshooting

### Connection Limit Exceeded

**Error:**
```
SQLSTATE[HY000] [1226] User has exceeded the 'max_connections_per_hour' resource
```

**Solutions:**
1. **Wait 30-60 minutes** - Limit resets automatically
2. **Switch to local database** - No limits
3. **Enable persistent connections** - `DB_PERSISTENT=true`
4. **Close unused tools** - SQLyog, phpMyAdmin, etc.
5. **Contact hosting provider** - Request limit increase

### Slow Queries

**Solutions:**
1. Enable query caching
2. Use database indexes
3. Optimize queries
4. Use eager loading in Laravel

### Connection Timeouts

**Solutions:**
1. Increase timeout: `DB_TIMEOUT=10`
2. Check network connectivity
3. Verify database server status

## 📈 Performance Tips

### 1. Use Query Builder
```php
// Good - Uses query builder
DB::table('users')->where('active', 1)->get();

// Avoid - Raw queries when not needed
DB::select('SELECT * FROM users WHERE active = 1');
```

### 2. Eager Loading
```php
// Good - Eager load relationships
$curriculums = Curriculum::with('subjects')->get();

// Avoid - N+1 query problem
$curriculums = Curriculum::all();
foreach ($curriculums as $curriculum) {
    $curriculum->subjects; // Separate query for each
}
```

### 3. Batch Operations
```php
// Good - Single query
User::insert($users);

// Avoid - Multiple queries
foreach ($users as $user) {
    User::create($user);
}
```

### 4. Connection Management
```php
// Close connection when done with heavy operations
DB::disconnect('mysql');
```

## 📝 Summary

**Quick Wins:**
1. 🏠 Use local database for development
2. 🔄 Enable persistent connections in production
3. 🔌 Close unused database tools
4. 📊 Monitor with `php artisan db:monitor`
5. ⚡ Use query builder and eager loading

**Impact:**
- ⭐⭐⭐⭐⭐ Local database for dev (eliminates limits)
- ⭐⭐⭐⭐ Persistent connections (reduces overhead)
- ⭐⭐⭐⭐ Close unused tools (prevents waste)
- ⭐⭐⭐ Monitoring (early detection)

## 🆘 Need Help?

Run the monitoring command to diagnose issues:
```bash
php artisan db:monitor --stats
```

Check the error message for specific guidance on connection limit errors.
