--
-- PostgreSQL database dump
--

\restrict TpW9oZB749t69KeKUk4QXbhb0LaOjQEAD3dYdPIiuNfhO4bGtzrYpBPSlwsYjuT

-- Dumped from database version 14.19 (Homebrew)
-- Dumped by pg_dump version 14.19 (Homebrew)

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

--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


--
-- Name: uuid-ossp; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;


--
-- Name: EXTENSION "uuid-ossp"; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';


--
-- Name: actualizar_cantidad_integrantes(); Type: FUNCTION; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE FUNCTION public.actualizar_cantidad_integrantes() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        UPDATE equipos 
        SET cantidad_integrantes = (
            SELECT COUNT(*) FROM miembros_equipo WHERE id_equipo = NEW.id_equipo
        ) 
        WHERE id = NEW.id_equipo;
    ELSIF TG_OP = 'DELETE' THEN
        UPDATE equipos 
        SET cantidad_integrantes = (
            SELECT COUNT(*) FROM miembros_equipo WHERE id_equipo = OLD.id_equipo
        ) 
        WHERE id = OLD.id_equipo;
    END IF;
    
    IF TG_OP = 'DELETE' THEN
        RETURN OLD;
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.actualizar_cantidad_integrantes() OWNER TO angelfrederickpizaojeda;

--
-- Name: generar_codigo_recurso(); Type: FUNCTION; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE FUNCTION public.generar_codigo_recurso() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF NEW.codigo IS NULL THEN
        NEW.codigo = 'REC-' || to_char(CURRENT_TIMESTAMP, 'YYYYMMDD') || '-' || 
                     LPAD(CAST(EXTRACT(EPOCH FROM CURRENT_TIMESTAMP)::INTEGER % 10000 AS TEXT), 4, '0');
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.generar_codigo_recurso() OWNER TO angelfrederickpizaojeda;

--
-- Name: update_timestamp(); Type: FUNCTION; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE FUNCTION public.update_timestamp() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.actualizado = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_timestamp() OWNER TO angelfrederickpizaojeda;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO angelfrederickpizaojeda;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO angelfrederickpizaojeda;

--
-- Name: comunarios_apoyo; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.comunarios_apoyo (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    nombre character varying(200) NOT NULL,
    edad integer,
    entidad_perteneciente character varying(200),
    equipoid uuid,
    creado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.comunarios_apoyo OWNER TO angelfrederickpizaojeda;

--
-- Name: TABLE comunarios_apoyo; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON TABLE public.comunarios_apoyo IS 'Comunarios que apoyan a los equipos de bomberos';


--
-- Name: equipos; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.equipos (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    nombre_equipo character varying(100) NOT NULL,
    cantidad_integrantes integer DEFAULT 0,
    id_lider_equipo uuid,
    estado character varying(255) DEFAULT 'ACTIVO'::character varying,
    creado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    actualizado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT equipos_estado_check CHECK (((estado)::text = ANY ((ARRAY['ACTIVO'::character varying, 'INACTIVO'::character varying, 'EN_MISION'::character varying])::text[])))
);


ALTER TABLE public.equipos OWNER TO angelfrederickpizaojeda;

--
-- Name: TABLE equipos; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON TABLE public.equipos IS 'Tabla de equipos de bomberos con ubicación geográfica';


--
-- Name: focos_calor; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.focos_calor (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    latitude numeric(10,8) NOT NULL,
    longitude numeric(11,8) NOT NULL,
    confidence integer,
    acq_date date NOT NULL,
    acq_time time(0) without time zone NOT NULL,
    bright_ti4 numeric(8,2),
    bright_ti5 numeric(8,2),
    frp numeric(8,2),
    creado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.focos_calor OWNER TO angelfrederickpizaojeda;

--
-- Name: TABLE focos_calor; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON TABLE public.focos_calor IS 'Datos satelitales de focos de calor detectados';


--
-- Name: miembros_equipo; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.miembros_equipo (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    id_equipo uuid,
    id_usuario uuid,
    fecha_ingreso timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.miembros_equipo OWNER TO angelfrederickpizaojeda;

--
-- Name: TABLE miembros_equipo; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON TABLE public.miembros_equipo IS 'Relación muchos a muchos entre usuarios y equipos';


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO angelfrederickpizaojeda;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO angelfrederickpizaojeda;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: noticias_incendios; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.noticias_incendios (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    title character varying(500) NOT NULL,
    date date NOT NULL,
    description text,
    url character varying(1000),
    image character varying(1000),
    creado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.noticias_incendios OWNER TO angelfrederickpizaojeda;

--
-- Name: TABLE noticias_incendios; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON TABLE public.noticias_incendios IS 'Noticias relacionadas con incendios';


--
-- Name: notifications; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.notifications (
    id uuid NOT NULL,
    type character varying(255) NOT NULL,
    notifiable_id uuid NOT NULL,
    notifiable_type character varying(255) NOT NULL,
    data text NOT NULL,
    read_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.notifications OWNER TO angelfrederickpizaojeda;

--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO angelfrederickpizaojeda;

--
-- Name: recursos; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.recursos (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    codigo character varying(50),
    descripcion text NOT NULL,
    fecha_pedido timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    estado_del_pedido character varying(255) DEFAULT 'PENDIENTE'::character varying,
    lat numeric(10,8),
    lng numeric(11,8),
    equipoid uuid,
    creado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    actualizado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT recursos_estado_del_pedido_check CHECK (((estado_del_pedido)::text = ANY ((ARRAY['PENDIENTE'::character varying, 'APROBADO'::character varying, 'RECHAZADO'::character varying, 'ENTREGADO'::character varying])::text[])))
);


ALTER TABLE public.recursos OWNER TO angelfrederickpizaojeda;

--
-- Name: TABLE recursos; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON TABLE public.recursos IS 'Recursos solicitados por los equipos';


--
-- Name: COLUMN recursos.codigo; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON COLUMN public.recursos.codigo IS 'Código único autogenerado para el recurso';


--
-- Name: reportes; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.reportes (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    nombre_reportante character varying(200) NOT NULL,
    telefono_contacto character varying(20),
    fecha_hora timestamp(0) without time zone NOT NULL,
    nombre_lugar character varying(200),
    tipo_incendio character varying(255),
    gravedad_incendio character varying(255),
    comentario_adicional text,
    cant_bomberos integer DEFAULT 0,
    cant_paramedicos integer DEFAULT 0,
    cant_veterinarios integer DEFAULT 0,
    cant_autoridades integer DEFAULT 0,
    estado character varying(255) DEFAULT 'PENDIENTE'::character varying,
    creado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT reportes_estado_check CHECK (((estado)::text = ANY ((ARRAY['PENDIENTE'::character varying, 'EN_PROCESO'::character varying, 'CONTROLADO'::character varying, 'EXTINGUIDO'::character varying])::text[]))),
    CONSTRAINT reportes_gravedad_incendio_check CHECK (((gravedad_incendio)::text = ANY ((ARRAY['Leve'::character varying, 'Moderado'::character varying, 'Grave'::character varying, 'Crítico'::character varying])::text[]))),
    CONSTRAINT reportes_tipo_incendio_check CHECK (((tipo_incendio)::text = ANY ((ARRAY['Forestal'::character varying, 'Estructural'::character varying, 'Vehicular'::character varying, 'Industrial'::character varying, 'Otro'::character varying])::text[])))
);


ALTER TABLE public.reportes OWNER TO angelfrederickpizaojeda;

--
-- Name: TABLE reportes; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON TABLE public.reportes IS 'Reportes rápidos de incendios realizados por ciudadanos';


--
-- Name: reportes_incendio; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.reportes_incendio (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    nombre_incidente character varying(200) NOT NULL,
    controlado boolean DEFAULT false,
    extension numeric(10,2),
    condiciones_clima text,
    equipos_en_uso text,
    numero_bomberos integer,
    necesita_mas_bomberos boolean DEFAULT false,
    apoyo_externo text,
    comentario_adicional text,
    fecha_creacion timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    id_usuario_creador uuid
);


ALTER TABLE public.reportes_incendio OWNER TO angelfrederickpizaojeda;

--
-- Name: TABLE reportes_incendio; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON TABLE public.reportes_incendio IS 'Reportes detallados de incendios realizados por bomberos';


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL,
    user_id uuid
);


ALTER TABLE public.sessions OWNER TO angelfrederickpizaojeda;

--
-- Name: users; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.users (
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    is_admin boolean DEFAULT false NOT NULL
);


ALTER TABLE public.users OWNER TO angelfrederickpizaojeda;

--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE TABLE public.usuarios (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    nombre character varying(100) NOT NULL,
    apellido character varying(100) NOT NULL,
    ci character varying(20) NOT NULL,
    fecha_nacimiento date NOT NULL,
    genero character varying(255),
    telefono character varying(20),
    email character varying(150) NOT NULL,
    password character varying(255) NOT NULL,
    tipo_de_sangre character varying(255),
    nivel_de_entrenamiento character varying(255),
    entidad_perteneciente character varying(200),
    rol character varying(255) DEFAULT 'BOMBERO'::character varying,
    estado character varying(255) DEFAULT 'PENDIENTE'::character varying,
    debe_cambiar_password boolean DEFAULT true,
    reset_token character varying(255),
    reset_token_expires timestamp(0) without time zone,
    creado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    actualizado timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT usuarios_estado_check CHECK (((estado)::text = ANY ((ARRAY['ACTIVO'::character varying, 'INACTIVO'::character varying, 'PENDIENTE'::character varying, 'ELIMINACION_SOLICITADA'::character varying])::text[]))),
    CONSTRAINT usuarios_genero_check CHECK (((genero)::text = ANY ((ARRAY['Masculino'::character varying, 'Femenino'::character varying, 'Otro'::character varying])::text[]))),
    CONSTRAINT usuarios_nivel_de_entrenamiento_check CHECK (((nivel_de_entrenamiento)::text = ANY ((ARRAY['Básico'::character varying, 'Intermedio'::character varying, 'Avanzado'::character varying, 'Experto'::character varying])::text[]))),
    CONSTRAINT usuarios_rol_check CHECK (((rol)::text = ANY ((ARRAY['ADMIN'::character varying, 'COORDINADOR'::character varying, 'BOMBERO'::character varying, 'PARAMEDICO'::character varying, 'VETERINARIO'::character varying])::text[]))),
    CONSTRAINT usuarios_tipo_de_sangre_check CHECK (((tipo_de_sangre)::text = ANY ((ARRAY['A+'::character varying, 'A-'::character varying, 'B+'::character varying, 'B-'::character varying, 'AB+'::character varying, 'AB-'::character varying, 'O+'::character varying, 'O-'::character varying])::text[])))
);


ALTER TABLE public.usuarios OWNER TO angelfrederickpizaojeda;

--
-- Name: TABLE usuarios; Type: COMMENT; Schema: public; Owner: angelfrederickpizaojeda
--

COMMENT ON TABLE public.usuarios IS 'Tabla de usuarios del sistema (bomberos, paramédicos, veterinarios, etc.)';


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: comunarios_apoyo comunarios_apoyo_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.comunarios_apoyo
    ADD CONSTRAINT comunarios_apoyo_pkey PRIMARY KEY (id);


--
-- Name: equipos equipos_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.equipos
    ADD CONSTRAINT equipos_pkey PRIMARY KEY (id);


--
-- Name: focos_calor focos_calor_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.focos_calor
    ADD CONSTRAINT focos_calor_pkey PRIMARY KEY (id);


--
-- Name: miembros_equipo miembros_equipo_id_equipo_id_usuario_key; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.miembros_equipo
    ADD CONSTRAINT miembros_equipo_id_equipo_id_usuario_key UNIQUE (id_equipo, id_usuario);


--
-- Name: miembros_equipo miembros_equipo_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.miembros_equipo
    ADD CONSTRAINT miembros_equipo_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: noticias_incendios noticias_incendios_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.noticias_incendios
    ADD CONSTRAINT noticias_incendios_pkey PRIMARY KEY (id);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- Name: recursos recursos_codigo_key; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.recursos
    ADD CONSTRAINT recursos_codigo_key UNIQUE (codigo);


--
-- Name: recursos recursos_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.recursos
    ADD CONSTRAINT recursos_pkey PRIMARY KEY (id);


--
-- Name: reportes_incendio reportes_incendio_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.reportes_incendio
    ADD CONSTRAINT reportes_incendio_pkey PRIMARY KEY (id);


--
-- Name: reportes reportes_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.reportes
    ADD CONSTRAINT reportes_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: usuarios usuarios_ci_key; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_ci_key UNIQUE (ci);


--
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- Name: idx_equipos_estado; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_equipos_estado ON public.equipos USING btree (estado);


--
-- Name: idx_equipos_lider; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_equipos_lider ON public.equipos USING btree (id_lider_equipo);


--
-- Name: idx_focos_coordenadas; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_focos_coordenadas ON public.focos_calor USING btree (latitude, longitude);


--
-- Name: idx_focos_fecha; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_focos_fecha ON public.focos_calor USING btree (acq_date);


--
-- Name: idx_miembros_equipo_equipo; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_miembros_equipo_equipo ON public.miembros_equipo USING btree (id_equipo);


--
-- Name: idx_miembros_equipo_usuario; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_miembros_equipo_usuario ON public.miembros_equipo USING btree (id_usuario);


--
-- Name: idx_recursos_equipo; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_recursos_equipo ON public.recursos USING btree (equipoid);


--
-- Name: idx_recursos_estado; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_recursos_estado ON public.recursos USING btree (estado_del_pedido);


--
-- Name: idx_reportes_fecha; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_reportes_fecha ON public.reportes USING btree (fecha_hora);


--
-- Name: idx_reportes_gravedad; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_reportes_gravedad ON public.reportes USING btree (gravedad_incendio);


--
-- Name: idx_reportes_tipo; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_reportes_tipo ON public.reportes USING btree (tipo_incendio);


--
-- Name: idx_usuarios_ci; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_usuarios_ci ON public.usuarios USING btree (ci);


--
-- Name: idx_usuarios_email; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_usuarios_email ON public.usuarios USING btree (email);


--
-- Name: idx_usuarios_estado; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_usuarios_estado ON public.usuarios USING btree (estado);


--
-- Name: idx_usuarios_rol; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX idx_usuarios_rol ON public.usuarios USING btree (rol);


--
-- Name: notifications_notifiable_id_notifiable_type_index; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX notifications_notifiable_id_notifiable_type_index ON public.notifications USING btree (notifiable_id, notifiable_type);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: angelfrederickpizaojeda
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: comunarios_apoyo comunarios_apoyo_equipoid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.comunarios_apoyo
    ADD CONSTRAINT comunarios_apoyo_equipoid_fkey FOREIGN KEY (equipoid) REFERENCES public.equipos(id) ON DELETE CASCADE;


--
-- Name: equipos equipos_id_lider_equipo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.equipos
    ADD CONSTRAINT equipos_id_lider_equipo_fkey FOREIGN KEY (id_lider_equipo) REFERENCES public.usuarios(id) ON DELETE SET NULL;


--
-- Name: miembros_equipo miembros_equipo_id_equipo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.miembros_equipo
    ADD CONSTRAINT miembros_equipo_id_equipo_fkey FOREIGN KEY (id_equipo) REFERENCES public.equipos(id) ON DELETE CASCADE;


--
-- Name: miembros_equipo miembros_equipo_id_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.miembros_equipo
    ADD CONSTRAINT miembros_equipo_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES public.usuarios(id) ON DELETE CASCADE;


--
-- Name: recursos recursos_equipoid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.recursos
    ADD CONSTRAINT recursos_equipoid_fkey FOREIGN KEY (equipoid) REFERENCES public.equipos(id) ON DELETE SET NULL;


--
-- Name: reportes_incendio reportes_incendio_id_usuario_creador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: angelfrederickpizaojeda
--

ALTER TABLE ONLY public.reportes_incendio
    ADD CONSTRAINT reportes_incendio_id_usuario_creador_fkey FOREIGN KEY (id_usuario_creador) REFERENCES public.usuarios(id);


--
-- PostgreSQL database dump complete
--

\unrestrict TpW9oZB749t69KeKUk4QXbhb0LaOjQEAD3dYdPIiuNfhO4bGtzrYpBPSlwsYjuT

