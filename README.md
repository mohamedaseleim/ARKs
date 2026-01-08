# ARK PubId Plugin for OJS 3.5+

This plugin provides [Archival Resource Key (ARK)](https://n2t.net/e/ark_ids.html) persistent identifier support for Open Journal Systems (OJS) 3.5.x.

It allows journal managers to assign unique ARK identifiers to Issues, Articles, and Galleys automatically or manually.

## 🚀 Features
- **OJS 3.5 Support:** Fully refactored for OJS 3.5.0.3+ and PHP 8.2+.
- **Flexible Patterns:** Define custom suffix patterns using variables (Volume, Issue, Page, ID, etc.).
- **Object Support:** Assign ARKs to Issues, Articles, and Galleys.
- **Custom Resolver:** Configure your preferred resolver URL (e.g., `https://n2t.net/`).
- **Multi-language:** Includes English (`en_US`) and Arabic (`ar_AR`) localizations.

## 📋 Requirements
- Open Journal Systems **3.5.0.3** or higher.
- PHP **8.1** or higher.

## 📦 Installation

### Option 1: Upload via OJS Dashboard
1. Download the `ark.zip` file from the releases (or zip the `ark` folder manually).
2. Login to your OJS dashboard as an Administrator.
3. Navigate to **Settings** > **Website** > **Plugins**.
4. Click **Upload A New Plugin** and select the zip file.
5. **Important:** After installation, go to **Administration** and click **Clear Data Caches** & **Clear Template Caches**.

### Option 2: Manual Installation
1. Copy the `ark` folder into your OJS installation directory at:
   `your-ojs-path/plugins/pubIds/ark`
2. Run the OJS upgrade tool or clear caches via CLI:
   ```bash
   php tools/upgrade.php tool upgrade
   php tools/cache.php clearTemplate
   php tools/cache.php clearData

⚙️ Configuration
Go to Settings > Website > Plugins.

Locate ARK PubId Plugin under the "Public Identifier Plugins" category.

Enable the plugin.

Click Settings to configure:

ARK Prefix: Your NAAN (e.g., ark:/12345).

Suffix Pattern: e.g., %j.v%vi%i.%a (Journal.Volume.Issue.ArticleID).

Resolver: The URL that resolves the ARK (e.g., https://n2t.net/).

🛠️ Credits

Original Author: Yasiel Pérez Vera

OJS 3.5 Upgrade & Refactoring: Mohamed Seleim

📄 License
Distributed under the GNU GPL v2. See the file docs/COPYING for full terms.
