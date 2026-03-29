# Arquitectura Hexagonal en Alxarafe

## Visión General

A partir de la versión v0.6.0, Alxarafe adopta una **Arquitectura Hexagonal** (también llamada Ports & Adapters) como su modelo arquitectónico principal. El framework actúa como un **Hub de Infraestructura** que centraliza puertos (interfaces) y adaptadores reutilizables para todo el ecosistema de aplicaciones.

## ¿Por qué Hexagonal?

| Problema (antes) | Solución (hexagonal) |
|---|---|
| Controladores acoplados a Eloquent | Los handlers usan puertos abstractos |
| Auth soldada a cookies | AuthPort permite sesiones, JWT, OAuth... |
| Imposible testear sin base de datos | Los puertos se mockean con adaptadores en memoria |
| Cada app reimplementa persistencia | Alxarafe centraliza adaptadores PDO reutilizables |

## Estructura de Capas

```
src/
├── Domain/                  # Contratos puros (interfaces)
│   ├── Port/
│   │   ├── Driven/          # Puertos secundarios (infraestructura)
│   │   │   ├── PersistencePort.php
│   │   │   ├── AuthPort.php
│   │   │   ├── MailerPort.php
│   │   │   └── LoggerPort.php
│   │   └── Driving/         # Puertos primarios (casos de uso)
│   │       └── CommandBusPort.php
│   └── Model/               # Tipos base de dominio
│       ├── AggregateRoot.php
│       ├── DomainEvent.php
│       └── EntityId.php
│
├── Application/             # Orquestación de casos de uso
│   ├── Bus/                 # Command/Query Bus
│   │   ├── Command.php
│   │   ├── CommandHandler.php
│   │   ├── Query.php
│   │   ├── QueryHandler.php
│   │   └── SimpleCommandBus.php
│   └── Service/
│       └── TransactionalService.php
│
└── Infrastructure/          # Implementaciones concretas
    ├── Adapter/
    │   ├── Persistence/     # PdoMysqlAdapter, PdoPgsqlAdapter, EloquentBridgeAdapter
    │   ├── Auth/            # SessionAuthAdapter
    │   ├── Mailer/          # SymfonyMailerAdapter
    │   └── Logger/          # FileLoggerAdapter, NullLoggerAdapter
    ├── Container/           # ServiceContainer (IoC)
    └── Legacy/              # Aliases de retro-compatibilidad
```

## Puertos Disponibles

### PersistencePort

Puerto genérico de persistencia que opera con arrays para máxima flexibilidad.

```php
use Alxarafe\Domain\Port\Driven\PersistencePort;

// Las apps construyen Repositories tipados encima:
class JokeRepository {
    public function __construct(private PersistencePort $db) {}

    public function findById(int $id): ?Joke {
        $row = $this->db->findById('jokes', $id);
        return $row ? Joke::fromArray($row) : null;
    }
}
```

**Métodos**: `findById()`, `findBy()`, `findOneBy()`, `insert()`, `update()`, `delete()`, `transactional()`, `rawQuery()`, `exists()`, `count()`

**Adaptadores disponibles**:
- `PdoMysqlAdapter` — PDO nativo para MySQL (recomendado para apps nuevas)
- `PdoPgsqlAdapter` — PDO nativo para PostgreSQL
- `EloquentBridgeAdapter` — Puente con el Eloquent existente (para migración gradual)

### AuthPort

Abstrae la autenticación del mecanismo concreto (sesiones, cookies, JWT).

**Métodos**: `authenticate()`, `getAuthenticatedUser()`, `isAuthenticated()`, `logout()`, `hasPermission()`, `hasRole()`, `getUserId()`

### MailerPort

Desacopla el envío de emails de la implementación concreta.

**Métodos**: `send()`, `sendBatch()`

### LoggerPort

Extiende PSR-3 (`Psr\Log\LoggerInterface`). Cualquier logger compatible con PSR-3 (como Monolog) funciona como adaptador sin necesidad de wrapper.

### CommandBusPort

Orquesta la ejecución de casos de uso de forma desacoplada de los controladores.

**Método**: `dispatch(Command $command)`

## Command Bus

El `SimpleCommandBus` permite desacoplar controladores de la lógica de negocio:

```php
// Registrar handlers
$bus = new SimpleCommandBus();
$bus->registerCommand(CreateJokeCommand::class, new CreateJokeHandler($jokeRepo));
$bus->registerQuery(GetJokeByIdQuery::class, new GetJokeByIdHandler($jokeRepo));

// Desde un controlador
$jokeId = $bus->dispatch(new CreateJokeCommand(
    title: 'Mi chiste',
    body: 'Contenido del chiste',
    authorId: 1
));

// Consulta
$joke = $bus->query(new GetJokeByIdQuery(jokeId: 42));
```

## Contenedor de Dependencias (IoC)

El `ServiceContainer` proporciona inyección de dependencias explícita:

```php
use Alxarafe\Infrastructure\Container\ServiceContainer;
use Alxarafe\Domain\Port\Driven\PersistencePort;
use Alxarafe\Infrastructure\Adapter\Persistence\PdoMysqlAdapter;

$container = new ServiceContainer();

// Registrar como singleton
$container->singleton(PersistencePort::class, fn($c) =>
    PdoMysqlAdapter::fromConfig($dbConfig)
);

// Resolver
$db = $container->get(PersistencePort::class);
```

## Guía de Migración para Aplicaciones

### Paso 1: Inyectar el PersistencePort

```php
// Antes (acoplado a Eloquent):
$user = User::find(42);

// Después (hexagonal):
$user = $this->persistence->findById('users', 42);
```

### Paso 2: Crear Repositories de Dominio

```php
// Interfaz en Domain/
interface UserRepository {
    public function findById(int $id): ?User;
    public function save(User $user): void;
}

// Implementación en Infrastructure/
class PdoUserRepository implements UserRepository {
    public function __construct(private PersistencePort $db) {}

    public function findById(int $id): ?User {
        $row = $this->db->findById('users', $id);
        return $row ? User::fromArray($row) : null;
    }
}
```

### Paso 3: Crear Handlers (Casos de Uso)

```php
class CreateUserHandler implements CommandHandler {
    public function __construct(private UserRepository $repo) {}

    public function handle(Command $command): mixed {
        $user = new User($command->name, $command->email);
        $this->repo->save($user);
        return $user->getId();
    }
}
```

## ADR-001: PersistencePort con Arrays

**Decisión**: El `PersistencePort` opera con `string $table` y `array` de datos, no con entidades tipadas.

**Justificación**: Alxarafe es un framework que da servicios de infraestructura a múltiples aplicaciones. Con arrays, centraliza adaptadores de persistencia reutilizables. Las aplicaciones consumidoras construyen Repositories tipados en su capa de dominio, manteniendo ortodoxia hexagonal completa.

**Flujo de tipos**:
```
Alxarafe (framework) → PersistencePort → array (genérico)
    ↑
App (Chascarrillo) → JokeRepository → Joke (tipado)
                        ↓
                   PersistencePort (Infraestructura de la app)
```

El dominio de la app nunca ve arrays ni tablas — solo ve Repositories tipados.

## Véase También

- [Arquitectura general](arquitectura.md) — Visión previa del framework
- [Ciclo de vida](ciclo_de_vida.md) — Flujo de ejecución de una petición
