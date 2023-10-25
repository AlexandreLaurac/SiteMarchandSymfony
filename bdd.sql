--
-- PostgreSQL database dump
--

-- Dumped from database version 14.5 (Ubuntu 14.5-0ubuntu0.22.04.1)
-- Dumped by pg_dump version 14.5 (Ubuntu 14.5-0ubuntu0.22.04.1)

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
-- Name: notify_messenger_messages(); Type: FUNCTION; Schema: public; Owner: mi5
--

CREATE FUNCTION public.notify_messenger_messages() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
            BEGIN
                PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$;


ALTER FUNCTION public.notify_messenger_messages() OWNER TO mi5;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: categorie; Type: TABLE; Schema: public; Owner: mi5
--

CREATE TABLE public.categorie (
    id integer NOT NULL,
    libelle character varying(255) NOT NULL,
    visuel character varying(255) DEFAULT NULL::character varying,
    texte character varying(511) DEFAULT NULL::character varying
);


ALTER TABLE public.categorie OWNER TO mi5;

--
-- Name: categorie_id_seq; Type: SEQUENCE; Schema: public; Owner: mi5
--

CREATE SEQUENCE public.categorie_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categorie_id_seq OWNER TO mi5;

--
-- Name: commande; Type: TABLE; Schema: public; Owner: mi5
--

CREATE TABLE public.commande (
    id integer NOT NULL,
    usager_id integer NOT NULL,
    date_commande date NOT NULL,
    statut character varying(255) NOT NULL
);


ALTER TABLE public.commande OWNER TO mi5;

--
-- Name: commande_id_seq; Type: SEQUENCE; Schema: public; Owner: mi5
--

CREATE SEQUENCE public.commande_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.commande_id_seq OWNER TO mi5;

--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: mi5
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO mi5;

--
-- Name: ligne_commande; Type: TABLE; Schema: public; Owner: mi5
--

CREATE TABLE public.ligne_commande (
    commande_id integer NOT NULL,
    produit_id integer NOT NULL,
    quantite smallint NOT NULL,
    prix double precision NOT NULL
);


ALTER TABLE public.ligne_commande OWNER TO mi5;

--
-- Name: ligne_commande_id_seq; Type: SEQUENCE; Schema: public; Owner: mi5
--

CREATE SEQUENCE public.ligne_commande_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ligne_commande_id_seq OWNER TO mi5;

--
-- Name: messenger_messages; Type: TABLE; Schema: public; Owner: mi5
--

CREATE TABLE public.messenger_messages (
    id bigint NOT NULL,
    body text NOT NULL,
    headers text NOT NULL,
    queue_name character varying(190) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    available_at timestamp(0) without time zone NOT NULL,
    delivered_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.messenger_messages OWNER TO mi5;

--
-- Name: messenger_messages_id_seq; Type: SEQUENCE; Schema: public; Owner: mi5
--

CREATE SEQUENCE public.messenger_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.messenger_messages_id_seq OWNER TO mi5;

--
-- Name: messenger_messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: mi5
--

ALTER SEQUENCE public.messenger_messages_id_seq OWNED BY public.messenger_messages.id;


--
-- Name: produit; Type: TABLE; Schema: public; Owner: mi5
--

CREATE TABLE public.produit (
    id integer NOT NULL,
    categorie_id integer NOT NULL,
    libelle character varying(255) NOT NULL,
    visuel character varying(255) DEFAULT NULL::character varying,
    texte character varying(511) DEFAULT NULL::character varying,
    prix double precision NOT NULL
);


ALTER TABLE public.produit OWNER TO mi5;

--
-- Name: produit_id_seq; Type: SEQUENCE; Schema: public; Owner: mi5
--

CREATE SEQUENCE public.produit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.produit_id_seq OWNER TO mi5;

--
-- Name: usager; Type: TABLE; Schema: public; Owner: mi5
--

CREATE TABLE public.usager (
    id integer NOT NULL,
    email character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL,
    nom character varying(255) NOT NULL,
    prenom character varying(255) NOT NULL
);


ALTER TABLE public.usager OWNER TO mi5;

--
-- Name: usager_id_seq; Type: SEQUENCE; Schema: public; Owner: mi5
--

CREATE SEQUENCE public.usager_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usager_id_seq OWNER TO mi5;

--
-- Name: messenger_messages id; Type: DEFAULT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.messenger_messages ALTER COLUMN id SET DEFAULT nextval('public.messenger_messages_id_seq'::regclass);


--
-- Data for Name: categorie; Type: TABLE DATA; Schema: public; Owner: mi5
--

COPY public.categorie (id, libelle, visuel, texte) FROM stdin;
1	Fruits	images/categories/fruits.jpg	De la passion ou de ton imagination
2	Légumes	images/categories/legumes.jpg	Plus tu en manges, moins tu en es un
3	Junk Food	images/categories/junk_food.jpg	Chère et cancérogène, tu es prévenu(e)
4	Virus	images/categories/corona.jpg	Une opportunité, il faut en profiter
\.


--
-- Data for Name: commande; Type: TABLE DATA; Schema: public; Owner: mi5
--

COPY public.commande (id, usager_id, date_commande, statut) FROM stdin;
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: mi5
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20230120104801	2023-01-20 11:50:42	131
DoctrineMigrations\\Version20230131152120	2023-01-31 16:21:53	97
DoctrineMigrations\\Version20230202111845	2023-02-02 12:18:59	115
\.


--
-- Data for Name: ligne_commande; Type: TABLE DATA; Schema: public; Owner: mi5
--

COPY public.ligne_commande (commande_id, produit_id, quantite, prix) FROM stdin;
\.


--
-- Data for Name: messenger_messages; Type: TABLE DATA; Schema: public; Owner: mi5
--

COPY public.messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) FROM stdin;
\.


--
-- Data for Name: produit; Type: TABLE DATA; Schema: public; Owner: mi5
--

COPY public.produit (id, categorie_id, libelle, visuel, texte, prix) FROM stdin;
1	1	Pomme	images/produits/pommes.jpg	Elle est bonne pour la tienne	3.42
2	1	Poire	images/produits/poires.jpg	Ici tu n'en es pas une	2.11
3	1	Pêche	images/produits/peche.jpg	Elle va te la donner	2.84
4	2	Carotte	images/produits/carottes.jpg	C'est bon pour ta vue	2.9
5	2	Tomate	images/produits/tomates.jpg	Fruit ou Légume ? Légume	1.7
6	2	Chou Romanesco	images/produits/romanesco.jpg	Mange des fractales	1.81
7	3	Nutella	images/produits/nutella.jpg	C'est bon, sauf pour ta santé	4.5
8	3	Pizza	images/produits/pizza.jpg	Y'a pas pire que za	8.25
9	3	Oreo	images/produits/oreo.jpg	Seulement si tu es un smartphone	2.5
10	4	Gel Hydroalcoolique	images/produits/gel.jpg	Usage interne ou externe	100
11	4	Masque FFP 200	images/produits/masque.jpg	Passe incognito face aux virus	200
12	4	Gants de Protection	images/produits/gants.jpg	Reste un touche à tout, avec feeling	50
\.


--
-- Data for Name: usager; Type: TABLE DATA; Schema: public; Owner: mi5
--

COPY public.usager (id, email, roles, password, nom, prenom) FROM stdin;
1	test@test.com	["ROLE_CLIENT"]	$2y$13$e/tvZHGSgeuh8p1jGSghIOJTES7F4cG.6sAPGUW4KIdMlA6rHRlAu	Test	Test
\.


--
-- Name: categorie_id_seq; Type: SEQUENCE SET; Schema: public; Owner: mi5
--

SELECT pg_catalog.setval('public.categorie_id_seq', 1, false);


--
-- Name: commande_id_seq; Type: SEQUENCE SET; Schema: public; Owner: mi5
--

SELECT pg_catalog.setval('public.commande_id_seq', 71, true);


--
-- Name: ligne_commande_id_seq; Type: SEQUENCE SET; Schema: public; Owner: mi5
--

SELECT pg_catalog.setval('public.ligne_commande_id_seq', 1, false);


--
-- Name: messenger_messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: mi5
--

SELECT pg_catalog.setval('public.messenger_messages_id_seq', 1, false);


--
-- Name: produit_id_seq; Type: SEQUENCE SET; Schema: public; Owner: mi5
--

SELECT pg_catalog.setval('public.produit_id_seq', 1, false);


--
-- Name: usager_id_seq; Type: SEQUENCE SET; Schema: public; Owner: mi5
--

SELECT pg_catalog.setval('public.usager_id_seq', 39, true);


--
-- Name: categorie categorie_pkey; Type: CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.categorie
    ADD CONSTRAINT categorie_pkey PRIMARY KEY (id);


--
-- Name: commande commande_pkey; Type: CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.commande
    ADD CONSTRAINT commande_pkey PRIMARY KEY (id);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: ligne_commande ligne_commande_pkey; Type: CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.ligne_commande
    ADD CONSTRAINT ligne_commande_pkey PRIMARY KEY (commande_id, produit_id);


--
-- Name: messenger_messages messenger_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.messenger_messages
    ADD CONSTRAINT messenger_messages_pkey PRIMARY KEY (id);


--
-- Name: produit produit_pkey; Type: CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.produit
    ADD CONSTRAINT produit_pkey PRIMARY KEY (id);


--
-- Name: usager usager_pkey; Type: CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.usager
    ADD CONSTRAINT usager_pkey PRIMARY KEY (id);


--
-- Name: idx_29a5ec27bcf5e72d; Type: INDEX; Schema: public; Owner: mi5
--

CREATE INDEX idx_29a5ec27bcf5e72d ON public.produit USING btree (categorie_id);


--
-- Name: idx_3170b74b82ea2e54; Type: INDEX; Schema: public; Owner: mi5
--

CREATE INDEX idx_3170b74b82ea2e54 ON public.ligne_commande USING btree (commande_id);


--
-- Name: idx_3170b74bf347efb; Type: INDEX; Schema: public; Owner: mi5
--

CREATE INDEX idx_3170b74bf347efb ON public.ligne_commande USING btree (produit_id);


--
-- Name: idx_6eeaa67d4f36f0fc; Type: INDEX; Schema: public; Owner: mi5
--

CREATE INDEX idx_6eeaa67d4f36f0fc ON public.commande USING btree (usager_id);


--
-- Name: idx_75ea56e016ba31db; Type: INDEX; Schema: public; Owner: mi5
--

CREATE INDEX idx_75ea56e016ba31db ON public.messenger_messages USING btree (delivered_at);


--
-- Name: idx_75ea56e0e3bd61ce; Type: INDEX; Schema: public; Owner: mi5
--

CREATE INDEX idx_75ea56e0e3bd61ce ON public.messenger_messages USING btree (available_at);


--
-- Name: idx_75ea56e0fb7336f0; Type: INDEX; Schema: public; Owner: mi5
--

CREATE INDEX idx_75ea56e0fb7336f0 ON public.messenger_messages USING btree (queue_name);


--
-- Name: uniq_3cdc65ffe7927c74; Type: INDEX; Schema: public; Owner: mi5
--

CREATE UNIQUE INDEX uniq_3cdc65ffe7927c74 ON public.usager USING btree (email);


--
-- Name: messenger_messages notify_trigger; Type: TRIGGER; Schema: public; Owner: mi5
--

CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON public.messenger_messages FOR EACH ROW EXECUTE FUNCTION public.notify_messenger_messages();


--
-- Name: produit fk_29a5ec27bcf5e72d; Type: FK CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.produit
    ADD CONSTRAINT fk_29a5ec27bcf5e72d FOREIGN KEY (categorie_id) REFERENCES public.categorie(id);


--
-- Name: ligne_commande fk_3170b74b82ea2e54; Type: FK CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.ligne_commande
    ADD CONSTRAINT fk_3170b74b82ea2e54 FOREIGN KEY (commande_id) REFERENCES public.commande(id);


--
-- Name: ligne_commande fk_3170b74bf347efb; Type: FK CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.ligne_commande
    ADD CONSTRAINT fk_3170b74bf347efb FOREIGN KEY (produit_id) REFERENCES public.produit(id);


--
-- Name: commande fk_6eeaa67d4f36f0fc; Type: FK CONSTRAINT; Schema: public; Owner: mi5
--

ALTER TABLE ONLY public.commande
    ADD CONSTRAINT fk_6eeaa67d4f36f0fc FOREIGN KEY (usager_id) REFERENCES public.usager(id);


--
-- PostgreSQL database dump complete
--

