'use client'

import axios from 'axios'
import { useState, useEffect } from 'react'
import { useParams } from 'next/navigation'
import PrefectureImage from './PrefectureImage'
import WeatherCard from '@/components/ui/WeatherCard'

const Prefecture = () => {
    const { prefecture } = useParams()
    const [weather, setWeather] = useState([])

    const decodeParam = param => decodeURIComponent(param)
    const decodedPrefecture = decodeParam(prefecture)

    useEffect(() => {
        const fetchWeatherData = async () => {
            if (prefecture) {
                try {
                    const response = await axios.get(
                        'http://localhost/api/travel_skies/get_prefecture_weather',
                        {
                            params: { prefecture: decodedPrefecture },
                        },
                    )
                    setWeather(response.data)
                    console.log(response.data)
                } catch (err) {
                    console.error('Error fetching weather data:', err)
                }
            }
        }
        fetchWeatherData()
    }, [prefecture])

    return (
        <>
            <h1>{decodedPrefecture}の天気</h1>
            <PrefectureImage
                decodedPrefecture={decodedPrefecture}
                weather={weather}
            />
            {/* {weather.length > 0 ? (
                weather.map((data, index) => (
                    <div key={index}>
                        <WeatherCard
                            weather_icon={data.weather.icon}
                            city_name={data.city_name}
                            weather_time={data.weather.weather_time}
                            temperature={data.weather.temperature}
                            temp_max={data.weather.temp_max}
                            temp_min={data.weather.temp_min}
                            humidity={data.weather.humidity}
                            feels_like={data.weather.feels_like}
                            main={data.weather.main}
                            description={data.weather.description}
                        />
                    </div>
                ))
            ) : (
                <p>Loading weather data...</p>
            )} */}
        </>
    )
}

export default Prefecture
