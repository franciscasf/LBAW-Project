# lbaw2434

# AskLEIC: A Platform for Collaboration and Learning
AskLEIC is a web-based platform designed to enhance collaboration and knowledge sharing within the Licenciatura em Engenharia Informática e Computação (LEIC) community. Tailored for students and staff, AskLEIC aims to bridge gaps in communication, foster academic discussions, and simplify access to valuable resources.

Through AskLEIC, users can ask questions about academic subjects, share learning materials, and solve challenges collaboratively. The platform promotes interaction between students and teachers, creating a vibrant and supportive educational environment.

To ensure a secure and organized experience, AskLEIC features role-based access for users, dividing them into groups with specific permissions, such as students, teachers, and administrators. Administrators are responsible for managing the platform, moderating content, and maintaining compliance with policies.

With a user-friendly interface and an adaptive design, AskLEIC ensures seamless navigation across devices, providing an exceptional user experience for the entire LEIC community. This project not only addresses academic needs but also fosters a spirit of collaboration and mutual growth, making it an invaluable tool for the LEIC journey.

## Project Components

* [ER: Requirements Specification](https://gitlab.up.pt/lbaw/lbaw2425/lbaw2434/-/wikis/ER:-Requirements-Specification)
* [EBD: Database Specification](https://gitlab.up.pt/lbaw/lbaw2425/lbaw2434/-/wikis/EBD:-Database-Specification)
* [EAP: Architecture Specification and Prototypes](https://gitlab.up.pt/lbaw/lbaw2425/lbaw2434/-/wikis/EAP:-Arquitecture-Specification)
* [PA: Product and Presentation](https://gitlab.up.pt/lbaw/lbaw2425/lbaw2434/-/wikis/PA:-Product-and-Presentation)

## Checklists

The artefacts checklist is available at: https://docs.google.com/spreadsheets/d/1TyKOAtIRPEusYvrm1aGqBPtD0TtnJSGo4N0o4woQBFw/edit?gid=537406521#gid=537406521

## Product

Docker command to launch the image available in the group's GitLab Container Registry:

```code
docker run -d --name lbaw2434 -p 8001:80 gitlab.up.pt:5050/lbaw/lbaw2425/lbaw2434
```

### Credentials

#### 2.1. Administration Credentials



| Username | Email | Password |
|----------|-------|----------|
| anaSilva | ana.silva@admin.com | 12345678 |

#### 2.2. User Credentials

| Type | Email | Username | Password |
|------|-------|----------|----------|
| basic account | fiona.duarte@example.com | fiona.d | 12345678 |
| moderator | filipe.brito@moderator.com | filipe.brito | 12345678 |

## Team

* Beatriz Pereira, up202207380@up.pt 
* Francisca Fernandes, up202106509@up.pt
* Luciano Ferreira, up202208158@up.pt
* Tomás Telmo, up202206091@up.pt
---

GROUP2434, 01/10/2024 - 22/12/2024