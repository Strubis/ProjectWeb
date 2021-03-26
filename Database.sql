drop database if exists williartsClients;
create database williartsClients
default character set utf8
default collate utf8_general_ci;

use williartsClients;

drop database williartsClients;

create table cliente(
	idCliente int not null auto_increment,
    nome_cliente varchar(80) not null,
    email_cliente varchar(100) not null,
    primary key(idCliente)
);

create table telefone(
	idTelefone int not null auto_increment,
    ddd int not null,
    numero int not null,
    fkCliente int not null,
    primary key(idTelefone),
    foreign key(fkCliente) references cliente (idCliente)
);

create table enderecos(
	idEndereco int not null auto_increment,
    cep varchar(10) not null,
    endereco varchar(80) not null,
    numero int,
    complemento varchar(50) default 'S/C',
    bairro varchar(80) not null,
    nome_cidade varchar(60) not null,
    sigla_estado varchar(2) not null,
    fkCliente int not null,
    primary key(idEndereco),
    foreign key(fkCliente) references cliente (idCliente)
);

insert into cliente(nome_cliente, email_cliente) values
('Emerson Silva', 'emersonlima910@gmail.com');
insert into telefone(ddd, numero, fkCliente) values
(16, 988720562, (select idCliente from cliente) );
insert into enderecos values
(1, '14078-160', 'Rua Monte Azul', 988, 'Casa rosa', 'Jardim Aeroporto', 
'Ribeirão Preto', 'SP', (select idCliente from cliente) );

insert into cliente values
(2, 'Carlos Nascimento', 'carlosnas@gmail.com');
insert into telefone values
(2, 21, 998127341, 2);
insert into enderecos values
(2, '16021-280', 'Rua Campo Azul', 90, 'Em frente ao bar', 'Vila Madalena', 
'Rio de Janeiro', 'RJ', 2);

insert into cliente values
(3, 'Jaqueline', 'jaque123@gmail.com');
insert into telefone values
(3, 16, 988765421, (select max(idCliente) from cliente));
insert into enderecos values
(3, '14078-230', 'Rua Monte Alto', 190, 'Esquina', 'Jardim Aeroporto', 
'Ribeirão Preto', 'SP', (select max(idCliente) from cliente));

SELECT cliente.nome_cliente, cliente.email_cliente, telefone.ddd, telefone.numero, enderecos.nome_cidade, enderecos.sigla_estado, enderecos.cep, enderecos.endereco, enderecos.numero, enderecos.complemento, enderecos.bairro FROM 
                            cliente INNER JOIN telefone ON cliente.idCliente = telefone.fkCliente
                                    INNER JOIN enderecos ON cliente.idCliente = enderecos.fkCliente;
                                    
SELECT cliente.nome_cliente, cliente.email_cliente, telefone.ddd, telefone.numero, enderecos.nome_cidade, enderecos.sigla_estado, 
		enderecos.cep, enderecos.endereco, enderecos.numero, enderecos.complemento, enderecos.bairro 
                            FROM cliente left JOIN telefone ON cliente.idCliente = telefone.fkCliente
                                        left JOIN enderecos ON cliente.idCliente = enderecos.fkCliente
							where nome_cliente like '%Emers%';

drop procedure insertClient;
select * from cliente where nome_cliente like '%Emerson%';
select * from telefone;
select * from cliente;
select * from enderecos;
select max(idCliente) from cliente;

delimiter &&
create procedure insertClient(in nome varchar(80), in email varchar(100), in ddd int, in telefone int,
					in cep varchar(10), in endereco varchar(80), in numCasa int, in compl varchar(50),
                    in bairro varchar(80), in cidade varchar(60), in estado varchar(2) )
begin
	insert into cliente(nome_cliente, email_cliente) values(nome, email);
    insert into telefone(ddd, numero, fkCliente) values(ddd, telefone, (select max(idCliente) from cliente) );
    insert into enderecos(cep, endereco, numero, complemento, bairro, nome_cidade, sigla_estado, fkCliente)
		values(cep, endereco, numCasa, compl, bairro, cidade, estado, (select max(idCliente) from cliente) );
end &&
delimiter ;
                                    
call insertClient('Lucas', 'lucas@outlook.com', 16, 988312453, '14078160', 'Rua Miranda', 710,
				   '', 'Vila Carvalho', 'Ribeirão Preto', 'SP');                        
                                    
delimiter &&
create procedure updateClient(in nomeAnt varchar(80), in nome varchar(80), in email varchar(100), in ddd int, in telefone int,
					in cep varchar(10), in endereco varchar(80), in numCasa int, in compl varchar(50),
                    in bairro varchar(80), in cidade varchar(60), in estado varchar(2) )
begin
    update cliente set nome_cliente=nome, email_cliente=email
			where idCliente = (select idCliente from 
				(select idCliente from cliente where nome_cliente like concat('%',nomeAnt,'%')) as s);
    
    update telefone set telefone.ddd=ddd, numero=telefone
    where fkCliente=(select idCliente from cliente where nome_cliente like concat('%', nomeAnt, '%') );
    
    update enderecos set enderecos.cep=cep, enderecos.endereco=endereco, numero=numCasa, complemento=compl, 
						enderecos.bairro=bairro, nome_cidade=cidade, sigla_estado=estado 
                        where fkCliente=(select idCliente from cliente where nome_cliente like concat('%', nomeAnt, '%') );
end &&
delimiter ;

call updateClient('Lucas', 'Marcos', 'lucas@outlook.com', 16, 988312453, '14078160', 'Rua Miranda', 710,
				   '', 'Vila Carvalho', 'Ribeirão Preto', 'SP');