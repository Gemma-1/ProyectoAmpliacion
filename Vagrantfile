Vagrant.configure("2") do |config|

  # Box Ubuntu Jammy (22.04 LTS) [cite: 1]
  config.vm.box = "ubuntu/jammy64"

  # Nombre de la VM
  config.vm.hostname = "Ubuntu-prAmpliacion"

  # Tiempo de espera para el arranque
  config.vm.boot_timeout = 600

  # Reenvío de puertos: Host 8080 -> Guest 80 (WordPress)
  config.vm.network "forwarded_port", guest: 80, host: 8080

  # Carpeta sincronizada para el proyecto
  config.vm.synced_folder ".", "/vagrant"

  # Configuración de recursos de hardware 
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "4096"
    vb.cpus = 2
  end

  # Provisionamiento: se ejecuta siempre con 'vagrant provision'
  config.vm.provision "shell", run: "always", inline: <<-SHELL
    set -e # Detener el script si hay errores

    # 1. Actualizar sistema e instalar dependencias básicas
    sudo apt-get update -y
    sudo apt-get install -y ca-certificates curl gnupg lsb-release git

    # 2. Configurar el repositorio oficial de Docker 
    sudo mkdir -p /etc/apt/keyrings
    if [ ! -f /etc/apt/keyrings/docker.gpg ]; then
        curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    fi

    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

    # 3. Instalar Docker y Docker Compose
    sudo apt-get update -y
    sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

    # 4. Configurar permisos para el usuario vagrant
    sudo usermod -aG docker vagrant

    # 5. Preparar el entorno del proyecto
    cd /vagrant
    mkdir -p web
    sudo chmod 777 web

    # 6. Actualización automática mediante contenedores
    echo "Sincronizando código desde GitHub..."
    # Ejecutamos el contenedor de git para actualizar los archivos en /web
    sudo docker compose run --rm git

    echo "Levantando servicios de WordPress y Base de Datos..." [cite: 6]
    # Levantamos los servicios principales en segundo plano
    sudo docker compose up -d wordpress db
    
    echo "Despliegue completado. Accede a http://localhost:8080"
  SHELL
end