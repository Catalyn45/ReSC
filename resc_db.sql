--
-- PostgreSQL database dump
--

-- Dumped from database version 13.3
-- Dumped by pg_dump version 13.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: admins; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admins (
    id bigint NOT NULL,
    name character varying(30) NOT NULL,
    password character varying(100) NOT NULL,
    email character varying(50) NOT NULL,
    server_id bigint,
    token character varying(100),
    photo character varying(100),
    verified boolean DEFAULT false NOT NULL
);


ALTER TABLE public.admins OWNER TO postgres;

--
-- Name: admins_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.admins ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.admins_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    id bigint NOT NULL,
    name character varying(30) NOT NULL,
    server_id bigint NOT NULL,
    waiting boolean NOT NULL,
    admin_id bigint,
    conversation_id bigint
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.clients ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: configurations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.configurations (
    id bigint NOT NULL,
    chatcolor_top character varying(6) NOT NULL,
    chatcolor_mid character varying(6) NOT NULL,
    chatcolor_input character varying(6) NOT NULL,
    chatcolor_button character varying(6) NOT NULL,
    chatcolor_client character varying(6) NOT NULL,
    chatcolor_stranger character varying(6) NOT NULL,
    chatposition_line smallint NOT NULL,
    chatposition_column smallint NOT NULL,
    class_name character varying(50),
    object_name character varying(50)
);


ALTER TABLE public.configurations OWNER TO postgres;

--
-- Name: configurations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.configurations ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.configurations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: confirms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.confirms (
    id bigint NOT NULL,
    token character varying(100) NOT NULL,
    admin_id bigint NOT NULL
);


ALTER TABLE public.confirms OWNER TO postgres;

--
-- Name: confirms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.confirms ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.confirms_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: conversations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.conversations (
    id bigint NOT NULL,
    created_at timestamp without time zone NOT NULL,
    admin_id bigint NOT NULL,
    client_name character varying(100) NOT NULL
);


ALTER TABLE public.conversations OWNER TO postgres;

--
-- Name: conversations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.conversations ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.conversations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: hosts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hosts (
    id bigint NOT NULL,
    name character varying(100) NOT NULL,
    server_id bigint
);


ALTER TABLE public.hosts OWNER TO postgres;

--
-- Name: hosts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.hosts ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.hosts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: keys; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.keys (
    id bigint NOT NULL,
    token character varying(100) NOT NULL,
    server_id bigint NOT NULL
);


ALTER TABLE public.keys OWNER TO postgres;

--
-- Name: keys_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.keys ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.keys_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: messages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.messages (
    sender character varying(10) NOT NULL,
    message character varying(500) NOT NULL,
    conversation_id bigint NOT NULL,
    created_at timestamp(6) without time zone NOT NULL,
    id bigint NOT NULL
);


ALTER TABLE public.messages OWNER TO postgres;

--
-- Name: messages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.messages ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: admins admins_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_pkey PRIMARY KEY (id);


--
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- Name: configurations configurations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configurations
    ADD CONSTRAINT configurations_pkey PRIMARY KEY (id);


--
-- Name: confirms confirms_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.confirms
    ADD CONSTRAINT confirms_pkey PRIMARY KEY (id);


--
-- Name: conversations conversations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.conversations
    ADD CONSTRAINT conversations_pkey PRIMARY KEY (id);


--
-- Name: hosts hosts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hosts
    ADD CONSTRAINT hosts_pkey PRIMARY KEY (id);


--
-- Name: keys keys_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.keys
    ADD CONSTRAINT keys_pkey PRIMARY KEY (id);


--
-- Name: admins unique_constraint; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins
    ADD CONSTRAINT unique_constraint UNIQUE (name);


--
-- Name: admins unique_constraint2; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins
    ADD CONSTRAINT unique_constraint2 UNIQUE (email);

INSERT INTO public.configurations (chatcolor_top, chatcolor_mid, chatcolor_input, chatcolor_button, chatcolor_client, chatcolor_stranger, chatposition_line, chatposition_column, class_name, object_name) VALUES
('4e37b6', 'a2bafa', 'ffffff', 'efefef', 'e9dbdb', '0e9aeb', 2, 2, 'Chat', 'chat');

INSERT INTO public.configurations (chatcolor_top, chatcolor_mid, chatcolor_input, chatcolor_button, chatcolor_client, chatcolor_stranger, chatposition_line, chatposition_column, class_name, object_name) VALUES
('4e37b6', 'a2bafa', 'ffffff', 'efefef', 'e9dbdb', '0e9aeb', 2, 2, 'Chat', 'chat');

INSERT INTO public.configurations (chatcolor_top, chatcolor_mid, chatcolor_input, chatcolor_button, chatcolor_client, chatcolor_stranger, chatposition_line, chatposition_column, class_name, object_name) VALUES
('4e37b6', 'a2bafa', 'ffffff', 'efefef', 'e9dbdb', '0e9aeb', 2, 2, 'Chat', 'chat');

INSERT INTO public.admins (name, password, email, server_id, token, photo, verified) VALUES
('admin', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'address@gmail.com', 3, NULL, '/resources/profile_pictures/default.png', TRUE);

INSERT INTO public.keys (token, server_id) VALUES ('1234', 3);
--
-- PostgreSQL database dump complete
--

