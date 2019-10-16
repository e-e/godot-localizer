from dotenv import load_dotenv
from pathlib import Path
import os

env_path = Path('.') / '.env'
load_dotenv(dotenv_path=env_path)

print("ok...\n")
print(os.getenv('DEV_ENV'))