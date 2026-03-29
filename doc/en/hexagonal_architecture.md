# Hexagonal Architecture in Alxarafe

## Overview

Starting with version 2026.1, Alxarafe adopts a **Hexagonal Architecture** (also known as Ports & Adapters) as its primary architectural model. The framework acts as an **Infrastructure Hub** that centralizes reusable ports (interfaces) and adapters for its entire application ecosystem.

## Why Hexagonal?

| Problem (before) | Solution (hexagonal) |
|---|---|
| Controllers coupled to Eloquent | Handlers use abstract ports |
| Auth hardwired to cookies | AuthPort enables sessions, JWT, OAuth... |
| Impossible to test without database | Ports can be mocked with in-memory adapters |
| Each app reimplements persistence | Alxarafe centralizes reusable PDO adapters |

## Layer Structure

```
src/
├── Domain/                  # Pure contracts (interfaces)
│   ├── Port/
│   │   ├── Driven/          # Secondary ports (infrastructure)
│   │   │   ├── PersistencePort.php
│   │   │   ├── AuthPort.php
│   │   │   ├── MailerPort.php
│   │   │   └── LoggerPort.php
│   │   └── Driving/         # Primary ports (use cases)
│   │       └── CommandBusPort.php
│   └── Model/               # Base domain types
│       ├── AggregateRoot.php
│       ├── DomainEvent.php
│       └── EntityId.php
│
├── Application/             # Use case orchestration
│   ├── Bus/                 # Command/Query Bus
│   │   ├── Command.php
│   │   ├── CommandHandler.php
│   │   ├── Query.php
│   │   ├── QueryHandler.php
│   │   └── SimpleCommandBus.php
│   └── Service/
│       └── TransactionalService.php
│
└── Infrastructure/          # Concrete implementations
    ├── Adapter/
    │   ├── Persistence/     # PdoMysqlAdapter, PdoPgsqlAdapter, EloquentBridgeAdapter
    │   ├── Auth/            # SessionAuthAdapter
    │   ├── Mailer/          # SymfonyMailerAdapter
    │   └── Logger/          # FileLoggerAdapter, NullLoggerAdapter
    ├── Container/           # ServiceContainer (IoC)
    └── Legacy/              # Backward-compatibility aliases
```

## Available Ports

### PersistencePort

Generic persistence port operating with arrays for maximum flexibility.

```php
use Alxarafe\Domain\Port\Driven\PersistencePort;

// Apps build typed Repositories on top:
class JokeRepository {
    public function __construct(private PersistencePort $db) {}

    public function findById(int $id): ?Joke {
        $row = $this->db->findById('jokes', $id);
        return $row ? Joke::fromArray($row) : null;
    }
}
```

**Methods**: `findById()`, `findBy()`, `findOneBy()`, `insert()`, `update()`, `delete()`, `transactional()`, `rawQuery()`, `exists()`, `count()`

**Available adapters**:
- `PdoMysqlAdapter` — Native PDO for MySQL (recommended for new apps)
- `PdoPgsqlAdapter` — Native PDO for PostgreSQL
- `EloquentBridgeAdapter` — Bridge with existing Eloquent (for gradual migration)

### AuthPort

Abstracts authentication from the concrete mechanism (sessions, cookies, JWT).

**Methods**: `authenticate()`, `getAuthenticatedUser()`, `isAuthenticated()`, `logout()`, `hasPermission()`, `hasRole()`, `getUserId()`

### MailerPort

Decouples email sending from the concrete implementation.

**Methods**: `send()`, `sendBatch()`

### LoggerPort

Extends PSR-3 (`Psr\Log\LoggerInterface`). Any PSR-3 compatible logger (like Monolog) works as an adapter without needing a wrapper.

### CommandBusPort

Orchestrates use case execution decoupled from controllers.

**Method**: `dispatch(Command $command)`

## Command Bus

The `SimpleCommandBus` decouples controllers from business logic:

```php
// Register handlers
$bus = new SimpleCommandBus();
$bus->registerCommand(CreateJokeCommand::class, new CreateJokeHandler($jokeRepo));
$bus->registerQuery(GetJokeByIdQuery::class, new GetJokeByIdHandler($jokeRepo));

// From a controller
$jokeId = $bus->dispatch(new CreateJokeCommand(
    title: 'My joke',
    body: 'Joke content',
    authorId: 1
));

// Query
$joke = $bus->query(new GetJokeByIdQuery(jokeId: 42));
```

## Dependency Container (IoC)

The `ServiceContainer` provides explicit dependency injection:

```php
use Alxarafe\Infrastructure\Container\ServiceContainer;
use Alxarafe\Domain\Port\Driven\PersistencePort;
use Alxarafe\Infrastructure\Adapter\Persistence\PdoMysqlAdapter;

$container = new ServiceContainer();

// Register as singleton
$container->singleton(PersistencePort::class, fn($c) =>
    PdoMysqlAdapter::fromConfig($dbConfig)
);

// Resolve
$db = $container->get(PersistencePort::class);
```

## Migration Guide for Applications

### Step 1: Inject the PersistencePort

```php
// Before (coupled to Eloquent):
$user = User::find(42);

// After (hexagonal):
$user = $this->persistence->findById('users', 42);
```

### Step 2: Create Domain Repositories

```php
// Interface in Domain/
interface UserRepository {
    public function findById(int $id): ?User;
    public function save(User $user): void;
}

// Implementation in Infrastructure/
class PdoUserRepository implements UserRepository {
    public function __construct(private PersistencePort $db) {}

    public function findById(int $id): ?User {
        $row = $this->db->findById('users', $id);
        return $row ? User::fromArray($row) : null;
    }
}
```

### Step 3: Create Handlers (Use Cases)

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

## ADR-001: PersistencePort with Arrays

**Decision**: PersistencePort operates with `string $table` and `array` data, not typed entities.

**Rationale**: Alxarafe is a framework providing infrastructure services to multiple applications. With arrays, it centralizes reusable persistence adapters. Consuming applications build typed Repositories in their domain layer, maintaining full hexagonal orthodoxy.

**Type flow**:
```
Alxarafe (framework) → PersistencePort → array (generic)
    ↑
App (Chascarrillo) → JokeRepository → Joke (typed)
                        ↓
                   PersistencePort (App's Infrastructure)
```

The app's domain never sees arrays or tables — only typed Repositories.

## See Also

- [General architecture](architecture.md) — Framework overview
- [Lifecycle](lifecycle.md) — Request execution flow
