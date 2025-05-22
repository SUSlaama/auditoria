import requests
import time

def acceder_url_para_backup(url_backup):
    print(f"Intentando acceder a la URL: {url_backup}")
    try:
        respuesta = requests.get(url_backup, timeout=30)
        respuesta.raise_for_status()

        print(f"Acceso exitoso. Código de estado: {respuesta.status_code}")
        return True

    except requests.exceptions.HTTPError as errh:
        print(f"Error HTTP: {errh}")
        if hasattr(errh, 'response') and errh.response is not None:
            print(f"Código de estado: {errh.response.status_code}")
            print(f"Respuesta del servidor (parcial): {errh.response.text[:200]}")
    except requests.exceptions.ConnectionError as errc:
        print(f"Error de Conexión: {errc}")
    except requests.exceptions.Timeout as errt:
        print(f"Error de Timeout: La petición tardó demasiado en responder.")
        print(f"Detalles: {errt}")
    except requests.exceptions.RequestException as err:
        print(f"Ocurrió un error inesperado al acceder a la URL: {err}")
    
    return False

if __name__ == "__main__":
    url_objetivo = "https://www.google.com/"

    print(f"Iniciando script de acceso a URL para backup ({time.strftime('%Y-%m-%d %H:%M:%S')}).")
    if acceder_url_para_backup(url_objetivo):
        print("El script completó el acceso a la URL de backup exitosamente.")
    else:
        print("El script no pudo completar el acceso a la URL de backup.")
    print(f"Script finalizado ({time.strftime('%Y-%m-%d %H:%M:%S')}).")
