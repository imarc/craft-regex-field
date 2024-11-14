# Regex Field

A CraftCMS field that validates inputs against a regex

## Requirements

This plugin requires Craft CMS 4.4.0 or later and PHP 8.0.2 or later, or Craft CMS 5.0 and PHP 8.2 or later.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “Regex Field”. Then press “Install”.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require imarc/craft-regex-field

# tell Craft to install the plugin
./craft plugin/install regex-field
```

## Usage

Create a new field and choose "Regex" as the field type.

<img width="322" alt="Screenshot 2024-11-11 at 12 10 08" src="https://github.com/user-attachments/assets/cce3b75e-bbf2-4542-8b9e-e1b1511e7c32">

Enter a regex pattern that all input in the field will be validated against.

<img width="1140" alt="Screenshot 2024-11-14 at 12 55 07" src="https://github.com/user-attachments/assets/45efd151-2b91-46ff-8a3c-d06c1e45a2bc">
