# TRAVEL SKIES
<img width="200" src="/Documents/Logo.png">

## データベース構成
```mermaid
---
title: "TRAVEL SKIES"
---
erDiagram
    %% REGIONS {
    %%     BIGINT id PK
    %%     VARCHAR(50) name
    %%     TEXT description
    %% }

    %% PREFECTURES {
    %%     BIGINT id PK
    %%     VARCHAR(50) name
    %%     BIGINT region_id FK
    %%     VARCHAR(255) image_url
    %%     TIMESTAMP created_at
    %%     TIMESTAMP updated_at
    %% }

    %% CITIES {
    %%     BIGINT id PK
    %%     VARCHAR(100) name
    %%     BIGINT prefecture_id FK
    %%     FLOAT latitude
    %%     FLOAT longitude
    %%     TIMESTAMP created_at
    %%     TIMESTAMP updated_at
    %% }

     japan_addresses {
        int id PK
        int ken_id
        int city_id
        int town_id
        string zip
        tinyint office_flg
        tinyint delete_flg
        string ken_name
        string ken_furi
        string city_name
        string city_furi
        string town_name
        string town_furi
        string town_memo
        string kyoto_street
        string block_name
        string block_furi
        string memo
        string office_name
        string office_furi
        string office_address
        int new_id
        timestamp created_at
        timestamp updated_at
    }

    WEATHERS {
        bigint id PK
        bigint city_id FK
        string country
        double lat
        double lon
        datetime weather_time
        string weather_main
        string weather_description
        string weather_icon
        float temperature
        float feels_like
        float temp_min
        float temp_max
        int pressure
        int humidity
        int visibility
        float wind_speed
        int wind_deg
        float rain_1h
        int clouds_all
        timestamp created_at
        timestamp updated_at
    }

    %% REGIONS ||--o{ PREFECTURES : "has"
    %% PREFECTURES ||--o{ CITIES : "has"
    japan_addresses ||--o{ WEATHERS : "has"


```
