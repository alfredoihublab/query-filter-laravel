# Query Filter for Laravel

This Project utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before install this package, make sure you have Composer installed on your machine.

Run this command:
```php
composer --version
```
### Installation

Install package via composer:

```php
composer require fguzman/query-filter-laravel
```
### How to use it

Create a new QueryClass with next command `make:query` and create a new FilterClass, you can use `make:filter` command.

Once these classes are created, you must implement the logic you need in each of them.

Note: your query class must be associated with the model for which you created it, so that you do not get errors in the filters.

For example, thinking about the User model

```php
php artisan make:query UserQuery
```
The above command will create a file named UserQuery with the following structure:

```
<?php

namespace App\Models\Queries;

use Fguzman\QueryBuilder;

class UserQuery extends QueryBuilder
{
    //
}
```

And the next command 

```php
php artisan make:filter FilterUser
```

This command will create a php file named UserFilter with the following structura.
```
<?php

namespace App\Filters;

use Fguzman\QueryFilter;

class UserFilter extends QueryFilter
{
    /**
     * Get the validation rules that apply to the request filter
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
```
Once you have created these classes you must associate the QueryClass to the model.

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\UserFilter;
use App\Models\Queries\UserQuery;

class User extends Model
{
    public function newQueryFilter()
    {
        return new UserFilter();
    }

    public function newEloquentBuilder($query)
    {
        return new UserQuery($query);
    }
}
```

Once is associate the QueryClass, you can create this first basic query filter

In your UserQuery file
```
<?php

namespace App\Models\Queries;

use Fguzman\QueryBuilder;

class UserQuery extends QueryBuilder
{
    public function findByName($name)
    {
        return $this->where(compact('name'))->first();
    }
}
```
Now you can use this query the following way:
```
User::query()->findByName('John');
```
Now, for UserFilter file you can use the following way:

```
<?php

namespace App\Filters;

use Fguzman\QueryFilter;
use App\Models\Queries\UserQuery;

class UserFilter extends QueryFilter
{
    public function rules(): array
    {
        return [
            'search' => 'filled',
        ];
    }

    public function search(UserQuery $query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }
}

```
now, in your UserController

```
<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->applyFilters()->paginate();

        return view('users.index', compact('users'));
    }
}
```

## Security

If you find any security issues, please email us at felipe-guzman.c@hotmail.com
