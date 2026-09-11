-- Adiciona as colunas necessárias para o Stripe na tabela de usuários
ALTER TABLE usuarios 
ADD COLUMN stripe_customer_id VARCHAR(255) NULL UNIQUE,
ADD COLUMN stripe_subscription_id VARCHAR(255) NULL UNIQUE,
ADD COLUMN subscription_status VARCHAR(50) DEFAULT 'inactive';
