import subprocess

def ping_infinite(ip):
    try:
        while True:
            # Exécuter la commande ping
            subprocess.run(["ping", ip], check=True)
    except KeyboardInterrupt:
        print("\nPing interrompu par l'utilisateur.")

# Remplacez '8.8.8.8' par l'adresse IP que vous souhaitez pinguer
ping_infinite("83.150.218.35")
