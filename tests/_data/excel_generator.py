import pandas as pd
import numpy as np
import random

# Updated lists with feminine names
names = ["María", "Ana", "Laura", "Lucía", "Elena", "Carmen", "Sara", "Isabel", "Pilar",
         "Clara", "Sofía", "Dolores", "Marta", "Victoria"]
surnames = ["González", "Martínez", "Crespo", "Condori", "Saldaña", "García", "Landa", "López",
            "Nasushkin", "Grapelli", "Witt", "Hidalgo", "Ortiz", "Llata", "Caprara", "Rodríguez",
            "Álvarez", "Del Rey", "Gándara", "Somavilla", "Cifrián", "Pastor"]
celulas = ["Judá", "Efraín", "El Shadai", "La Roca", "Yahvé", "Adonai", "Cristo Redentor", "Edificando", "Maranatha", "El Reposo"]

# Function to generate random feminine names with Spanish naming conventions
def generate_nombre_apellidos():
    first_name = random.choice(names)
    second_name = random.choice(names) if random.random() > 0.5 else ''
    first_surname = random.choice(surnames)
    second_surname = random.choice(surnames)
    return f"{first_name} {second_name} {first_surname} {second_surname}".strip()

# Function to generate a random Spanish phone number with prefix
def generate_telefono():
    prefix = "+34"
    number = f"{prefix} {random.randint(600000000, 699999999)}"
    return number

# Function to generate a username similar to AddUserForm logic
def generate_username(nombre_apellidos, celula):
    nombre_part = ''.join(nombre_apellidos.split()[:2]).lower()[:4]
    celula_part = celula[:3].lower()  # First 3 letters of celula
    date_part = f"{random.randint(1, 31):02}{random.randint(1, 12):02}"  # Random day and month in 'ddmm' format
    return f"{nombre_part}{celula_part}{date_part}"

# Function to generate an email based on the username
def generate_email(username):
    return f"{username}@example.com"

# Generate 100 mock registries
data = {
    "nombre_apellidos": [generate_nombre_apellidos() for _ in range(100)],
    "rol": [random.choice(["alumna","maestra"])] * 100,
    "fecha_nacimiento": [f"{random.randint(1980, 2010)}-{random.randint(1, 12):02}-{random.randint(1, 28):02}" for _ in range(100)],
    "celula": [random.choice(celulas) for _ in range(100)],
    "fecha_ingreso": [f"{random.randint(2015, 2023)}-{random.randint(1, 12):02}-{random.randint(1, 28):02}" for _ in range(100)],
    "fecha_graduacion": [f"{random.randint(2024, 2027)}-{random.randint(1, 12):02}-{random.randint(1, 28):02}" for _ in range(100)],
    "email": [f'usuario{i}@example.com' for i in range(1, 101)],
    "color": [random.choice(["Rojo", "Verde", "Azul", "Amarillo"]) for _ in range(100)],
    "password": [f"password{random.randint(1000, 9999)}" for _ in range(100)],
    "telefonos": [generate_telefono() for _ in range(100)],
    'niveles': np.random.choice(['Azul', 'Blanco', 'Rojo', 'Rosa'], size=100),
    'funciones': np.random.choice(['titular', 'auxiliar'], size=100)

}

# Create a DataFrame and save as an Excel file
df = pd.DataFrame(data)
file_path = "mock_users.xlsx"
df.to_excel(file_path, index=False)
file_path
