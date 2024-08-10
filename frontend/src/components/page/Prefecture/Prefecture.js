'use client'

import axios from 'axios'
import { useState, useEffect } from 'react'
import { useParams } from 'next/navigation'

const Prefecture = () => {
    const { prefecture } = useParams()
    const [weather, setWeather] = useState([])

    // URLパラメータをデコードする関数
    const decodeParam = param => decodeURIComponent(param)

    useEffect(() => {
        const fetchWeatherData = async () => {
            if (prefecture) {
                const decodedPrefecture = decodeParam(prefecture)
                console.log(decodedPrefecture)
                try {
                    const response = await axios.get(
                        'http://localhost/api/travel_skies/get_prefecture_weather',
                        {
                            params: { prefecture: decodedPrefecture },
                        },
                    )
                    setWeather(response.data)
                    console.log(weather)
                } catch (err) {
                    console.error('Error fetching weather data:', err)
                }
            }
        }
        fetchWeatherData()
    }, [prefecture])

    useEffect(() => {
        console.log('Weather data updated:', weather)
    }, [weather]) // `weather` が変更されたときにログを表示

    return (
        <>
            {weather.length > 0 ? (
                weather.map((data, index) => (
                    <div key={index}>
                        <h2>{data.city}</h2>
                        <p>{JSON.stringify(data.weather)}</p>

                        {data.weather.weather.map((weatherInfo, idx) => (
                            <p key={idx}>
                                <img
                                    src={`https://openweathermap.org/img/wn/${weatherInfo.icon}@2x.png`}
                                    alt="weather_icon"
                                />
                                {weatherInfo.main} - {weatherInfo.description}
                            </p>
                        ))}
                    </div>
                ))
            ) : (
                <p>Loading weather data...</p>
            )}
        </>
    )
}

export default Prefecture
