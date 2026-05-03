# PHP API Scaffolder

Tool for generating backend project structures dynamically and exporting them as downloadable ZIP files.

## 🚀 Features

- Dynamic generation of backend structure (routes, models, controllers)
- Automatic file and folder creation
- ZIP packaging of generated projects
- Direct download via browser
- Cleanup of previously generated files

## 🧠 How it works

1. User provides configuration (module name, endpoints, etc.)
2. Backend generates project structure dynamically
3. Generated files are compressed into a ZIP
4. ZIP is stored in `public/zipfiles`
5. User downloads the generated project

## 🧩 Architecture

- `StructureGenerator` → Handles dynamic file and folder creation
- `ZipService` → Handles compression logic
- `index.php` → Entry point and orchestration
- `public/zipfiles` → Stores downloadable generated files

## 📂 Project Structure
src/
└── services/
├── StructureGenerator.php
└── ZipService.php

public/
└── zipfiles/

assets/
├── css/
└── js/


## 📦 File Handling

Generated ZIP files are stored in:
public/zipfiles/


Before generating a new file, previous ZIP files are automatically removed to keep the workspace clean.

## ⚠️ Current State

This project is under active refactoring:

- Service-based architecture implemented
- Public/private separation introduced
- Download handling improved

## 🎯 Purpose

This project was built to:

- Practice backend architecture
- Automate repetitive setup tasks
- Simulate real-world API scaffolding tools

## 🚀 Future Improvements

- Template-based file generation (`.tpl.php`)
- CLI version
- Support for more endpoint types (PUT, DELETE)
- Configurable environments