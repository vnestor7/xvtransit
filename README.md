# XVTransit

**Projecte de digitalització per millorar la gestió del transport públic**

Projecte realitzat dins del mòdul **M12 – Projecte Intermodular** del cicle **SMX2B – Sistemes Microinformàtics i Xarxes**.

**Autors:** Xincheng Ye i Viorel Nestor Manibog Spulber  
**Curs:** 2025-2026

---

## Què és XVTransit?

XVTransit és un projecte pensat per millorar la manera com es consulta i es gestiona el transport públic.

La idea és crear una plataforma digital amb una part per als usuaris i una altra part per a la gestió interna. Això permet tenir la informació més ordenada, més clara i més fàcil d’utilitzar.

El projecte combina diferents àrees treballades al cicle, com la web, la xarxa, els sistemes, la seguretat, les dades i la documentació tècnica.

---

## Problema que volem solucionar

En molts serveis de transport, la informació no sempre és fàcil de trobar. Els usuaris poden tenir dificultats per consultar horaris, rutes, avisos o informació del servei.

També pot passar que la gestió interna estigui separada en diferents eines, cosa que fa que el treball sigui menys ordenat.

XVTransit intenta donar una solució més centralitzada i clara, tant per als viatgers com per als treballadors.

---

## Objectius del projecte

L’objectiu principal és plantejar una solució digital per modernitzar la gestió del transport públic.

Objectius principals:

- Millorar la informació que rep l’usuari.
- Facilitar la consulta de rutes, horaris i avisos.
- Proposar una part privada per a la gestió interna.
- Organitzar millor les dades del servei.
- Aplicar mesures bàsiques de seguretat.
- Preparar una base que es pugui ampliar en el futur.
- Documentar el projecte de forma clara i ordenada.

---

## Funcionalitats generals

### Part pública

La part pública està pensada per als viatgers.

Pot incloure:

- consulta de rutes;
- consulta d’horaris;
- informació de parades;
- avisos del servei;
- mapa o informació visual;
- compra o consulta de bitllets;
- ajuda bàsica per a l’usuari.

### Part privada

La part privada està pensada per a la gestió interna.

Pot incloure:

- gestió de rutes;
- gestió d’horaris;
- gestió d’incidències;
- control d’informació del servei;
- validació o revisió de bitllets;
- consulta de dades internes;
- gestió d’usuaris i permisos.

---

## Arquitectura general

El sistema es planteja de manera general amb aquests elements:

```txt
Usuaris
   ↓
Part pública
   ↓
Sistema central
   ↓
Dades del servei
   ↑
Part privada
   ↑
Treballadors / operadors
```

La idea és que totes les parts treballin connectades, però separant bé la informació pública de la informació interna.

També es contempla una infraestructura bàsica amb servidor, comunicacions, còpies de seguretat i control d’accés.

---

## Tecnologies i àrees treballades

En aquest projecte es treballen diferents àrees tècniques:

| Àrea | Ús dins del projecte |
|---|---|
| Desenvolupament web | Crear la part visual i funcional de la plataforma |
| Programació | Afegir funcionalitats bàsiques |
| Bases de dades | Guardar informació del servei |
| Xarxes | Connectar els diferents elements del sistema |
| Sistemes operatius | Preparar l’entorn on funcionarien els serveis |
| Seguretat | Protegir accessos, dades i comunicacions |
| Documentació | Explicar el projecte, les decisions i les proves |
| Gestió del projecte | Organitzar fases, tasques i entregables |

---

## Estructura del repositori

Estructura recomanada del projecte:

```txt
XVTransit/
│
├── demo/
│   └── Proves i material de demostració
│
├── memòria tècnica/
│   └── Documents principals del projecte
│
├── presentació/
│   └── Material per a la defensa
│
├── docs/
│   └── Documentació complementària
│
├── web/
│   └── Fitxers de la plataforma web
│
├── infraestructura/
│   └── Esquemes, xarxa i seguretat
│
├── logo-xvtransit.png
│
└── README.md
```

Aquesta estructura ajuda a tenir el repositori més ordenat i fàcil de revisar.

---

## Planificació general

El projecte s’ha organitzat en fases:

1. **Anàlisi inicial**  
   Definició del problema, objectius i abast.

2. **Disseny del sistema**  
   Preparació de l’estructura general, casos d’ús i esquemes.

3. **Desenvolupament**  
   Creació de la part web i funcionalitats principals.

4. **Infraestructura i seguretat**  
   Proposta de xarxa, servidor, accessos i còpies.

5. **Proves i revisió**  
   Comprovació del funcionament i correcció d’errors.

6. **Documentació final**  
   Preparació de la memòria, annexos i presentació.

---

## Casos d’ús principals

Els casos d’ús principals del projecte són:

1. L’usuari consulta informació del servei.
2. L’usuari veu informació actualitzada del transport.
3. L’usuari consulta avisos o incidències.
4. L’operador gestiona dades del servei.
5. El sistema rep o actualitza informació dels vehicles.
6. El personal autoritzat valida informació o bitllets.

Aquests casos d’ús serveixen per explicar què ha de fer el sistema i quines parts necessita.

---

## Proposta de prova pilot

El projecte es planteja com una prova pilot, no com una implantació completa en una empresa real.

La prova pilot serveix per demostrar la idea principal del sistema i comprovar que la solució podria funcionar en un entorn més real.

Inclou:

- una web de demostració;
- una part de gestió interna;
- dades de prova;
- documentació tècnica;
- esquemes i plànols;
- pressupost orientatiu;
- proves bàsiques de funcionament.

---

## Resultats aconseguits

Amb aquest projecte s’ha aconseguit:

- definir una proposta completa;
- explicar el problema i la solució;
- preparar casos d’ús;
- crear una arquitectura general;
- plantejar una estructura de repositori;
- preparar documentació tècnica;
- fer una planificació;
- crear material visual per entendre millor el sistema;
- aplicar coneixements del cicle SMX.

---

## Millores futures

En un futur es podria ampliar el projecte amb més automatització i més funcions intel·ligents.

Algunes millores possibles:

- avisos més automàtics;
- millor gestió de dades;
- més proves amb un entorn real;
- app mòbil;
- més estadístiques;
- millora de la part privada;
- integració amb altres sistemes.

---

## Equip

Projecte realitzat per:

- **Xincheng Ye**
- **Viorel Nestor Manibog Spulber**

El treball s’ha fet de manera conjunta, participant tots dos membres en les diferents parts del projecte.

---

## Estat actual

- [x] Idea i objectius definits
- [x] Memòria tècnica preparada
- [x] Casos d’ús documentats
- [x] Arquitectura general definida
- [x] Planificació preparada
- [x] Material visual preparat
- [x] Demo i proves bàsiques
- [ ] Revisió final del repositori
- [ ] Presentació final

---

## Llicència

Aquest repositori forma part d’un projecte acadèmic del mòdul **M12 – Projecte Intermodular**.

El contingut s’utilitza per documentar i presentar el projecte XVTransit.

---

## Resum final

XVTransit és una proposta per fer el transport públic més clar, modern i fàcil de gestionar.

El projecte uneix part pública, part privada, dades, xarxa, seguretat i documentació per mostrar una solució completa però entenedora a nivell de SMX.
