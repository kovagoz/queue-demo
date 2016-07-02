# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "debian/jessie64"

  # Application
  config.vm.network "forwarded_port", guest: 8000, host: 8000

  # RabbitMQ management console
  config.vm.network "forwarded_port", guest: 15672, host: 8001

  # Mailcatcher
  config.vm.network "forwarded_port", guest: 1080, host: 8002

  config.vm.provider "virtualbox" do |vb|
    vb.gui = false
    vb.memory = "512"
  end

  config.vm.provision "ansible_local" do |ansible|
      ansible.playbook = "playbook.yml"
      ansible.provisioning_path = "/vagrant/server"
  end
end
