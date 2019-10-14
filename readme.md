## Godot Localizer

- Create and download a credentials JSON file for the Google Translate API.
- Rename `.env.example` to `.env`, and set `GOOGLE_TRANSLATE_KEYFILE_PATH` to the path to your `credentials.json` file
- Create a base translation CSV file:

  | id  | en  | ja  | de  |
  |:---|:---|:---|:---|
  | GREETING | Hello  |   |   |
  | FAREWELL | Goodbye  |   |   |
  
- Run the command: `php translate /path/to/input.csv /path/to/desired/output.csv`
  - If `/path/to/desired/output.csv` exists, you will be prompted with whether or not to overwrite the existing file

- Output generated will be a CSV file with the values filled in:

  | id  | en  | ja  | de  |
  |:---|:---|:---|:---|
  | GREETING | Hello  | こんにちは  | Hallo  |
  | FAREWELL | Goodbye  | さようなら  | Auf Wiedersehen  |

---

[See the Godot docs](https://docs.godotengine.org/en/latest/getting_started/workflow/assets/importing_translations.html#doc-importing-translations) for more info about localization in Godot

