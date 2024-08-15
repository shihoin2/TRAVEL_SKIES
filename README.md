# TRAVEL SKIES
<img width="200" src="/Documents/Logo.png">

## データベース構成
```mermaid
---
title: "TRAVEL SKIES"
---
erDiagram
    daily_weather {
        int id PK
        string city_name
        double lat
        double lon
        datetime weather_time
        datetime sunrise
        datetime sunset
        datetime moonrise
        datetime moonset
        float moon_phase
        string summary
        float temp_day
        float temp_min
        float temp_max
        float temp_night
        float temp_eve
        float temp_morn
        float feels_like_day
        float feels_like_night
        float feels_like_eve
        float feels_like_morn
        int pressure
        int humidity
        float dew_point
        float wind_speed
        int wind_deg
        float wind_gust
        string weather_main
        string weather_description
        string weather_icon
        int clouds
        float pop
        float rain
        float uvi
        datetime created_at
        datetime updated_at
        }

     japan_address {
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

    weather {
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



```
