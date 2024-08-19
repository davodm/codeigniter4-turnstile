# Cloudflare Turnstile for CodeIgniter 4
![Build Status](https://github.com/davodm/codeigniter4-turnstile/actions/workflows/main.yml/badge.svg)
![Packagist Version](https://img.shields.io/packagist/v/davodm/codeigniter4-turnstile)
![License](https://img.shields.io/github/license/davodm/codeigniter4-turnstile)
![Downloads](https://img.shields.io/packagist/dt/davodm/codeigniter4-turnstile)
![GitHub stars](https://img.shields.io/github/stars/davodm/codeigniter4-turnstile?style=social)

**CI4CFTurnstile** is a [CodeIgniter 4](https://github.com/codeigniter4/CodeIgniter4) library that integrates Cloudflare's Turnstile CAPTCHA for form validation. It supports both implicit and explicit rendering modes.

You can find the document of Cloudflare Turnstile [here](https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/).

## Installation
### 1. Composer Installation
Install the package via [Composer](https://getcomposer.org/):

```bash
composer require davodm/codeigniter4-turnstile
```
### 2. Configuration
After installation, configure your Cloudflare Turnstile site and secret keys. You can do this by setting the environment variables in your .env file:

```bash
turnstile.siteKey=your-site-key
turnstile.secretKey=your-secret-key
```

## Usage

### Rendering CAPTCHA

The library provides helper functions `turnsitle` to render the CAPTCHA in your views: `turnstile_implicit()`, `turnstile_explicit()`, and `turnstile_explicit_render()`.


#### Implicit Mode
In your view file, you can render the Turnstile CAPTCHA in implicit mode by calling:

```php
helper('turnstile');
echo turnstile_implicit('turnstile_field_name', 'auto', 'normal');
```

#### Explicit Mode

For explicit mode, you need to follow these steps:

1. **Register Fields**: In your view file, register the fields where the CAPTCHA should appear:

```php
helper('turnstile');
turnstile_explicit('turnstile_field_name', 'dark', 'normal');
```

2. **Create a <div> Element**: Manually create a <div> element in your view with an id matching the fieldName parameter:

```php
<div id="turnstile_field_name"></div>
```

3. **Render the CAPTCHA**: Finally, render the CAPTCHA by calling turnstile_explicit_render() before the closing </body> tag:

```php
<?= turnstile_explicit_render(); ?>
```

### Validation
To validate the CAPTCHA response, you can use the TurnstileRules validation rule in your controller or model.

#### Adding the Validation Rule
First, register the validation rule in your validation configuration file (`app/Config/Validation.php`):

```php
public $ruleSets = [
    // other rules
    \CI4CFTurnstile\Validation\TurnstileRules::class,
];
```

Then, in your form validation logic:

```php
$validation = \Config\Services::validation();

$validation->setRules([
    'turnstile_field_name' => 'required|turnstile_verify',
]);

if (!$validation->withRequest($this->request)->run()) {
    // Handle validation errors
    $errors = $validation->getErrors();
    // Display errors to the user
}
```

## Example
Here’s a complete example of using CI4CFTurnstile in a controller:

```php
namespace App\Controllers;

use CodeIgniter\Controller;

class FormController extends Controller
{
    public function index()
    {
        helper('turnstile');
        return view('form');
    }

    public function submit()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'turnstile_field_name' => 'required|turnstile_verify',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // CAPTCHA passed
        // Proceed with form processing
    }
}
```
In your form.php view file:

```php
<!-- Implicit form model -->
<form method="post" action="/form/submit">
    <!-- Other form fields -->
    <?= turnstile_implicit('turnstile_field_name'); ?>
    <button type="submit">Submit</button>
</form>


<!-- Explicit form model -->
<form method="post" action="/form/submit">
    <!-- Other form fields -->
    <div id="turnstile_field_name"></div>
    <?= turnstile_explicit('turnstile_field_name', 'dark', 'normal'); ?>
    <button type="submit">Submit</button>
</form>
<?=turnstile_explicit_render?>
</body>
```

## License
This project is licensed under the MIT License - see the [License](./License) file for details.


## Author
Davod Mozafari - [Twitter](https://twitter.com/davodmozafari)
