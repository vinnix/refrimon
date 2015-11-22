# refrimon

Sistema de Lojas








# Instruções técnicas

- Criação do banco de dados

 $ mysql -u root -p

 mysql>  CREATE USER 'refrimonusr'@'localhost' IDENTIFIED BY 'refrimonusr9990';
 mysql>  GRANT ALL PRIVILEGES ON *.* TO 'refrimonusr'@'localhost';
 mysql>  FLUSH PRIVILEGES;


 $ mysql -u refrimonusr -p
