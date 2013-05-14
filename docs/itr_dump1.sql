--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.9
-- Dumped by pg_dump version 9.2.2
-- Started on 2013-05-14 23:43:24

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 200 (class 1259 OID 33005)
-- Name: tm_user_hash; Type: TABLE; Schema: public; Owner: garage; Tablespace: 
--

CREATE TABLE tm_user_hash (
    user_id bigint,
    attribute_key character varying(255) NOT NULL,
    title character varying(255) NOT NULL,
    type_id bigint NOT NULL,
    list_value text
);


ALTER TABLE public.tm_user_hash OWNER TO garage;

--
-- TOC entry 2007 (class 0 OID 33005)
-- Dependencies: 200
-- Data for Name: tm_user_hash; Type: TABLE DATA; Schema: public; Owner: garage
--

INSERT INTO tm_user_hash (user_id, attribute_key, title, type_id, list_value) VALUES (NULL, 'name', 'Имя пользователя (ФИО)', 1, ' ');
INSERT INTO tm_user_hash (user_id, attribute_key, title, type_id, list_value) VALUES (NULL, 'birthday', 'Дата рождения', 1, '');
INSERT INTO tm_user_hash (user_id, attribute_key, title, type_id, list_value) VALUES (NULL, 'phone', 'Телефон', 1, '');
INSERT INTO tm_user_hash (user_id, attribute_key, title, type_id, list_value) VALUES (NULL, 'email', 'Электронная почта', 1, '');


--
-- TOC entry 2006 (class 2606 OID 57354)
-- Name: tm_user_hash_pkey; Type: CONSTRAINT; Schema: public; Owner: garage; Tablespace: 
--

ALTER TABLE ONLY tm_user_hash
    ADD CONSTRAINT tm_user_hash_pkey PRIMARY KEY (attribute_key);


-- Completed on 2013-05-14 23:43:24

--
-- PostgreSQL database dump complete
--

