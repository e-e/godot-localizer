## Godot Localizer
 

- Create and download a credentials JSON file for the Google Translate API.
- Rename `.env.example` to `.env`, and set `GOOGLE_TRANSLATE_KEYFILE_PATH` to the path to your `credentials.json` file
- Create a base translation CSV file (the langauge codes here should be only those supported by Google Translate; See note below):

  | id       | en      | ja  | de  |
  | :------- | :------ | :-- | :-- |
  | GREETING | Hello   |     |     |
  | FAREWELL | Goodbye |     |     |

- Run the command: 
  - **PHP**
    - `cd ./php/composer.phar install`
    - `./translate php /path/to/input.csv /path/to/output.csv`



- If `/path/to/desired/output.csv` exists, you will be prompted with whether or not to overwrite the existing file

- Output generated will be a CSV file with the values filled in:

  | id       | en      | ja         | de              |
  | :------- | :------ | :--------- | :-------------- |
  | GREETING | Hello   | こんにちは | Hallo           |
  | FAREWELL | Goodbye | さようなら | Auf Wiedersehen |

---

_Note:_

Some of the language codes required for Google Translate are not compatible with Godot. If you are translating for one of those languages:

- Rename `lang-codes.example.json` to `lang-codes.json`
- Define your mappings


[See the Godot docs](https://docs.godotengine.org/en/latest/getting_started/workflow/assets/importing_translations.html#doc-importing-translations) for more info about localization in Godot

---

_**Disclaimer**
The purpose of this "tool" is to aid in rapid localization for projects such as game jams, where translations would be a nice addition, but coordinating with real tranlators is not feasible given the time constraints. Serious projects deserve translations done by a professional or someone with a native-like understanding of both the source and target languages._
