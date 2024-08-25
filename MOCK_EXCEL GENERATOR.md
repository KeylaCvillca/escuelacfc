## Setup

### 1. Install Python 3.11
Ensure you have Python 3.11 installed. You can download it from the official [Python website](https://www.python.org/downloads/).

### 2. Create and activate a virtual environment

In the root directory of your project, run the following commands:

```bash
python3.11 -m venv .venv
source .venv/bin/activate
```

### 3. Install dependencies

Run the command for installing the dependencies

```bash
pip install -r venv_requirements
```

### 4. Deactivate and reactivate the virtual enviroment

When you're done working, deactivate the virtual environment with:

```bash
deactivate
```

Whenever you start a new session, reactivate the virtual environment with:

```bash
Copiar código
source .venv/bin/activate
```