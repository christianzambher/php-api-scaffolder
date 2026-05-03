# PHP API Scaffolder

Tool for dynamically generating backend project structures using a template-based system and exporting them as downloadable ZIP files.

## 🚀 Features

- Dynamic backend structure generation
- Template-based file creation (`.tpl.php`)
- Automatic ZIP packaging of generated projects
- Direct browser download
- Cleanup of previously generated files
- Configurable basePath for flexible environments

## 🧠 How it works

1. User provides configuration (API name, module, endpoints, etc.)
2. The system generates the project structure dynamically
3. Templates are processed and converted into real files
4. The project is compressed into a ZIP file
5. The ZIP is stored in `public/zipfiles`
6. User downloads the generated project

## 🧩 Architecture

- `StructureGenerator` → Orchestrates structure creation
- `TemplateService` → Handles template rendering
- `ZipService` → Handles compression
- `index.php` → Entry point
- `public/zipfiles` → Stores generated ZIP files

## 📂 Project Structure
src/  
├── services/  
│ ├── StructureGenerator.php  
│ ├── TemplateService.php  
│ └── ZipService.php  
│  
└── templates/  
│ ├── funciones.tpl.php  
│ ├── htaccess.tpl.php  
│ ├── rutas.tpl.php  
│ ├── html.tpl.php  
│ ├── js.tpl.php  
│ ├── services.tpl.php  
│ └── public_index.tpl.php  

public/  
└── zipfiles/  


## 🧩 Template System

The project uses a simple template engine based on placeholders:
{{VariableName}}


These placeholders are dynamically replaced during file generation.
### Example:
```php
$templateService->render('template.tpl.php', [
    'ClassName' => 'clsUser'
]);
```

## ⚙️ Configuration
basePath can be dynamically defined or omitted
Supports flexible environments (with or without parent folder)

## 📦 File Handling
Generated ZIP files are stored in:
public/zipfiles/
Previous ZIP files are automatically removed before generating a new one

## 🎯 Purpose

This project was built to:

Practice backend architecture design
Automate repetitive project setup
Simulate real-world scaffolding tools