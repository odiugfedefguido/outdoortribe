# Design

## Schema generale cose da fare
- Mockup 
- Schema E/R 
- Creazione database 
- Sviluppo backend: PHP
- Sviluppo frontend: HTML, CSS, JavaScript

### Suddivisione frontend

| @simo                | @fede                              | @vaso                      |
|----------------------|------------------------------------|----------------------------|
| - Header, Footer     | - UserProfile                      | - Create Activity          |
| - Login              |     - Adventures done/liked/created|     - Check                |
| - Registration       |     - UserPhotos                   |     - Waypoints            |
| - Homepage           |     - Followers                    |     - Upload Images        |
| - Research, Searching|     - Notifications                |     - Rating               |
| - Post details       | - Friend/other-user profile        |     - Post Created         |
|   - Images gallery   | - Add&Share Activity (PostDetails) | - Find friends             |

**N.B.** *Le pagine del sito, con il relativo css e javascript, le mettiamo nella cartella public. Gli elementi che possono essere riutilizzati (es. header,footer) li mettiamo in templates. <br> Usiamo per ora Roboto come font generale, copiare nell'head di ogni pagina il contenuto di assets/fonts/Roboto.hml*