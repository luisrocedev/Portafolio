-- ============================================
-- ACTUALIZACIÓN: Añadir campo para video demo
-- Fecha: 3 de octubre de 2025
-- ============================================

USE portafolio_db;

-- Añadir columna video_url a la tabla projects
ALTER TABLE projects 
ADD COLUMN video_url VARCHAR(500) AFTER live_url;

-- Verificar cambios
DESCRIBE projects;
