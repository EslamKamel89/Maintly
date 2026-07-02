# Authentication API (OpenAPI Style)

## Base URL

```
/api
```

---

## POST `/auth/register`

Creates a new organization and its owner account.

### Request

**Content-Type**

```http
application/json
```

### Request Body

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "organization_name": "Acme Maintenance"
}
```

### Request Schema

```yaml
type: object
required:
    - name
    - email
    - password
    - organization_name

properties:
    name:
        type: string
        example: John Doe

    email:
        type: string
        format: email
        example: john@example.com

    password:
        type: string
        format: password
        example: password

    organization_name:
        type: string
        example: Acme Maintenance
```

---

## Responses

### 201 Created

```json
{
    "message": "Registration successful.",
    "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "user": {
        "id": 1,
        "organization_id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "owner",
        "created_at": "2026-07-02T06:20:00.000000Z",
        "updated_at": "2026-07-02T06:20:00.000000Z",
        "organization": {
            "id": 1,
            "name": "Acme Maintenance",
            "created_at": "2026-07-02T06:20:00.000000Z",
            "updated_at": "2026-07-02T06:20:00.000000Z"
        }
    }
}
```

### Response Schema

```yaml
type: object

properties:
    message:
        type: string

    token:
        type: string

    user:
        $ref: "#/components/schemas/User"
```

---

### 422 Unprocessable Entity

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "organization_name": ["The organization name has already been taken."]
    }
}
```

---

## Business Rules

- Creates a new Organization.
- Creates a new User.
- Assigns the user to the created organization.
- User role is automatically set to `owner`.
- Generates a Sanctum Personal Access Token.
- Entire operation runs inside a database transaction.

---

# POST `/auth/login`

Authenticates an existing user.

### Request

**Content-Type**

```http
application/json
```

### Request Body

```json
{
    "email": "john@example.com",
    "password": "password"
}
```

### Request Schema

```yaml
type: object

required:
    - email
    - password

properties:
    email:
        type: string
        format: email
        example: john@example.com

    password:
        type: string
        format: password
        example: password
```

---

## Responses

### 200 OK

```json
{
    "message": "Login successful.",
    "token": "2|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "user": {
        "id": 1,
        "organization_id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "owner",
        "created_at": "2026-07-02T06:20:00.000000Z",
        "updated_at": "2026-07-02T06:20:00.000000Z",
        "organization": {
            "id": 1,
            "name": "Acme Maintenance",
            "created_at": "2026-07-02T06:20:00.000000Z",
            "updated_at": "2026-07-02T06:20:00.000000Z"
        }
    }
}
```

### Response Schema

```yaml
type: object

properties:
    message:
        type: string

    token:
        type: string

    user:
        $ref: "#/components/schemas/User"
```

---

### 422 Unprocessable Entity

```json
{
    "message": "The provided credentials are incorrect."
}
```

---

# Authentication

All protected endpoints require a Bearer token.

```
Authorization: Bearer {access_token}
```

Example:

```http
GET /api/user
Authorization: Bearer 2|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
Accept: application/json
```

---

# Components

## User

```yaml
User:
    type: object

    properties:
        id:
            type: integer

        organization_id:
            type: integer

        name:
            type: string

        email:
            type: string
            format: email

        role:
            type: string
            enum:
                - owner
                - admin
                - manager
                - technician

        created_at:
            type: string
            format: date-time

        updated_at:
            type: string
            format: date-time

        organization:
            $ref: "#/components/schemas/Organization"
```

---

## Organization

```yaml
Organization:
    type: object

    properties:
        id:
            type: integer

        name:
            type: string

        created_at:
            type: string
            format: date-time

        updated_at:
            type: string
            format: date-time
```

---

# Security Scheme

```yaml
securitySchemes:
    BearerAuth:
        type: http
        scheme: bearer
        bearerFormat: Sanctum Token
```

---

# Security

```yaml
security:
    - BearerAuth: []
```
