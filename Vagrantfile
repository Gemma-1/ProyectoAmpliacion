Vagrant.configure("2") do |config|

  # Box Ubuntu
  config.vm.box = "ubuntu/jammy64"

  # Nombre de la VM
  config.vm.hostname = "Ubuntu-prAmpliacion"

  #Tiempo de espera
  config.vm.boot_timeout = 600

  # Forwarding WordPress
  config.vm.network "forwarded_port", guest: 80, host: 8080

  # Carpeta sincronizada
  config.vm.synced_folder ".", "/vagrant"

  # Recursos VM
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "4096"
    vb.cpus = 2
  end

  # Provisioning 
  config.vm.provision "shell", run: "always", inline: <<-SHELL

    # Actualizar sistema
    sudo apt update

    # Instalar dependencias
    sudo apt install -y ca-certificates curl gnupg lsb-release git

    # Instalar Docker
    sudo mkdir -p /etc/apt/keyrings
    if [ ! -f /etc/apt/keyrings/docker.gpg ]; then
        curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    fi

    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

    sudo apt update
    sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

    # Permisos docker
    sudo usermod -aG docker vagrant

    # Entrar en la carpeta del proyecto
    cd /vagrant

    # Permisos para la carpeta web
    mkdir -p web && sudo chmod 777 web

    # Actualizacion desde GitHub
    sudo docker compose up git --force-recreate

    # 4. Levantar el resto de servicios (WordPress y DB)
    sudo docker compose up -d wordpress db
  SHELL
end