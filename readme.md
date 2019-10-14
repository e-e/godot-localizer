## Godot Translation Generator

- Create and download a credentials JSON file for the Google Translate API.
- Rename `.env.example` to `.env`, and set the path your credentials file in the `GOOGLE_TRANSLATE_KEYFILE_PATH` variable
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

