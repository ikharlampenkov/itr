<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 28.04.13
 * Time: 22:53
 * To change this template use File | Settings | File Templates.
 */

/*
 * CREATE TABLE project
 (
   id bigserial NOT NULL,
   title character varying(50) NOT NULL, -- Название проекта
   is_company boolean NOT NULL DEFAULT false, -- Вы - компания?
   company_title character varying, -- Название комании
   company_contact_fio character varying, -- Ф.И.О. контактного лица
   company_contact_phone character varying, -- Контактный телефон
   company_contact_email character varying, -- E-mail	*
   description character varying, -- Описание проекта
   resulting_products character varying(220), -- Вид результирующей продукции (или технологии) проекта
   basic_function character varying(1024), -- Базовые функции (по возможности не более 5)
   additional_features character varying(520), -- Дополнительные функции
   potential_customers character varying(520), -- Потенциальные потребители
   analogs character varying(1024), -- Существующие аналоги
   branch_id bigint, -- Отрасль
   stage_id bigint, -- Стадия проекта
   requirements_id bigint, -- Надо для завершения
   requirements_text character varying(520), -- Надо для завершения текст
   date_create date NOT NULL, -- Дата создания
   CONSTRAINT project_pkey PRIMARY KEY (id),
   CONSTRAINT project_branch_id_fkey FOREIGN KEY (branch_id)
       REFERENCES project_branch (id) MATCH SIMPLE
       ON UPDATE CASCADE ON DELETE RESTRICT,
   CONSTRAINT project_requirements_id_fkey FOREIGN KEY (requirements_id)
       REFERENCES project_requirements (id) MATCH SIMPLE
       ON UPDATE CASCADE ON DELETE RESTRICT,
   CONSTRAINT project_stage_id_fkey FOREIGN KEY (stage_id)
       REFERENCES project_stage (id) MATCH SIMPLE
       ON UPDATE CASCADE ON DELETE RESTRICT
 )
 WITH (
   OIDS=FALSE
 );
 ALTER TABLE project
   OWNER TO garage;
 COMMENT ON TABLE project
   IS 'Таблица проектов';
 COMMENT ON COLUMN project.title IS 'Название проекта';
 COMMENT ON COLUMN project.is_company IS 'Вы - компания?';
 COMMENT ON COLUMN project.company_title IS 'Название комании';
 COMMENT ON COLUMN project.company_contact_fio IS 'Ф.И.О. контактного лица';
 COMMENT ON COLUMN project.company_contact_phone IS 'Контактный телефон';
 COMMENT ON COLUMN project.company_contact_email IS 'E-mail	*					';
 COMMENT ON COLUMN project.description IS 'Описание проекта';
 COMMENT ON COLUMN project.resulting_products IS 'Вид результирующей продукции (или технологии) проекта';
 COMMENT ON COLUMN project.basic_function IS 'Базовые функции (по возможности не более 5)';
 COMMENT ON COLUMN project.additional_features IS 'Дополнительные функции';
 COMMENT ON COLUMN project.potential_customers IS 'Потенциальные потребители	';
 COMMENT ON COLUMN project.analogs IS 'Существующие аналоги';
 COMMENT ON COLUMN project.branch_id IS 'Отрасль';
 COMMENT ON COLUMN project.stage_id IS 'Стадия проекта';
 COMMENT ON COLUMN project.requirements_id IS 'Надо для завершения';
 COMMENT ON COLUMN project.requirements_text IS 'Надо для завершения текст		';
 COMMENT ON COLUMN project.date_create IS 'Дата создания';
 */

/**
 * Class SM_Project_Project
 */
class SM_Project_Project
{


}