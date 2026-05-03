# php-api-scaffolder
Functional PHP API scaffolding tool

## ⚠️ Current State

This version includes a functional backend structure generator with ZIP export.

- Logic has been partially refactored into services
- File generation and compression are working
- Project structure is being improved progressively

Future improvements will focus on:
- Moving public assets to a dedicated public directory
- Improving download path handling
- Template-based file generation

## 🧩 Architecture

- `StructureGenerator` → Handles dynamic file and folder creation
- `ZipService` → Handles compression of generated projects
- `index.php` → Acts as entry point and orchestrator

## 🔄 Flow

1. User sends configuration via frontend
2. Backend generates project structure dynamically
3. Files are compressed into a ZIP
4. ZIP is returned for download