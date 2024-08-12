'use client'

import axios from 'axios'
import { useState, useEffect } from 'react'
import { useParams } from 'next/navigation'
import DailyWeatherTable from './DailyWeatherTable'
import DailyWeatherCard from './DailyWeatherCard'

const City = () => {
    const { city } = useParams()
    const [currentWeather, setCurrentWeather] = useState([])
    const [dailyWeather, setDailyWeather] = useState([])
    const [pastWeather, setPastWeather] = useState([])
    const [tomorrowWeather, setTomorrowWeather] = useState([])
    // URLパラメータをデコードする
    const decodeParam = param => decodeURIComponent(param)

    const formatDate = dateString => {
        const date = new Date(dateString)

        const year = date.getFullYear()
        const month = date.getMonth() + 1
        const day = date.getDate()
        const hours = date.getHours().toString().padStart(2, '0')
        const minutes = date.getMinutes().toString().padStart(2, '0')
        return `${year}/${month}/${day} ${hours}:${minutes}`
    }

    useEffect(() => {
        const fetchWeatherData = async () => {
            if (city) {
                const decodedCity = decodeParam(city)
                console.log(decodedCity)
                try {
                    const response = await axios.get(
                        'http://localhost/api/travel_skies/get_city_weather',
                        {
                            params: { city: decodedCity },
                        },
                    )
                    setCurrentWeather(response.data.current_weather)
                    console.log('current:', response.data.current_weather)
                    console.log('tomorrow-:', response.data.daily_weather)
                    // 今日の日付（00:00:00）
                    const today = new Date()
                    today.setHours(0, 0, 0, 0)
                    const todayTimestamp = today.getTime()

                    // 明日の日付（00:00:00）
                    const tomorrow = new Date(today)
                    tomorrow.setDate(today.getDate() + 1)

                    // 明日の日付のタイムスタンプ
                    const tomorrowTimestamp = tomorrow.getTime()

                    console.log(tomorrowTimestamp)
                    console.log(todayTimestamp)
                    // 明日の日付+時間
                    const filteredTomorrowWeather =
                        response.data.daily_weather.filter(data => {
                            const weatherDate = new Date(
                                data.weather.weather_time,
                            )
                            weatherDate.setHours(0, 0, 0, 0)
                            return weatherDate.getTime() === tomorrowTimestamp
                        })

                    // 明後日以降の天気
                    const filteredFutureDailyWeather =
                        response.data.daily_weather.filter(data => {
                            const weatherDate = new Date(
                                data.weather.weather_time,
                            )
                            weatherDate.setHours(0, 0, 0, 0)
                            return weatherDate.getTime() > tomorrowTimestamp
                        })

                    // 過去の天気全て
                    const pastDailyWeather = response.data.daily_weather.filter(
                        data => {
                            const weatherDate = new Date(
                                data.weather.weather_time,
                            )
                            weatherDate.setHours(0, 0, 0, 0)
                            return weatherDate.getTime() < todayTimestamp
                        },
                    )

                    // 過去2日間の天気
                    const filteredPastDailyWeather = pastDailyWeather.slice(-2)

                    setTomorrowWeather(filteredTomorrowWeather)
                    setDailyWeather(filteredFutureDailyWeather)
                    setPastWeather(filteredPastDailyWeather)
                } catch (err) {
                    console.error('Error fetching weather data:', err)
                }
            }
        }
        fetchWeatherData()
    }, [city])

    useEffect(() => {
        console.log('dailyWeather:', dailyWeather)
    }, [dailyWeather])

    // pastWeather が更新された時に内容を表示
    useEffect(() => {
        console.log('pastWeather:', pastWeather)
    }, [pastWeather])

    // tomorrowWeather が更新された時に内容を表示
    useEffect(() => {
        console.log('tomorrowWeather:', tomorrowWeather)
    }, [tomorrowWeather])

    return (
        <>
            <div className="bg-white pb-6 sm:pb-8 lg:pb-12">
                {currentWeather.length > 0 &&
                    currentWeather.map((data, index) => (
                        <div key={index}>
                            <h1 className="mb-8 text-xl font-bold text-black sm:text-3xl md:mb-12 md:text-3xl">
                                {data.city_name}
                            </h1>
                        </div>
                    ))}
                <div className="mx-auto max-w-screen-2xl px-4 md:px-8">
                    {/* text - start */}
                    <div className="mb-4 md:mb-4">
                        <h2 className="mb-4 text-left text-xl font-bold text-gray-800 md:mb-6 lg:text-2xl">
                            今日明日の天気
                        </h2>
                    </div>
                    {/* text - end */}
                    <div className="grid gap-6 sm:grid-cols-2">
                        {currentWeather.length > 0 &&
                            currentWeather.map((data, index) => (
                                // <div key={index}>
                                <DailyWeatherCard
                                    key={index}
                                    icon={data.weather.icon}
                                    city_name={data.city_name}
                                    weather_time={data.weather.weather_time}
                                    temperature={data.weather.temperature}
                                    temp_max={data.weather.temp_max}
                                    temp_min={data.weather.temp_min}
                                    humidity={data.weather.humidity}
                                    feels_like={data.weather.feels_like}
                                    main={data.weather.main}
                                    description={data.weather.description}
                                    pop={0.3}
                                />
                            ))}
                        {tomorrowWeather.length > 0 &&
                            tomorrowWeather.map((data, index) => (
                                <DailyWeatherCard
                                    key={index}
                                    icon={data.weather.icon}
                                    city_name={data.city_name}
                                    weather_time={data.weather.weather_time}
                                    temperature={data.weather.temperature}
                                    temp_max={data.weather.temp_max}
                                    temp_min={data.weather.temp_min}
                                    humidity={data.weather.humidity}
                                    feels_like={data.weather.feels_like}
                                    main={data.weather.main}
                                    description={data.weather.description}
                                    pop={data.weather.pop}
                                />
                            ))}
                    </div>
                </div>
            </div>
            <div className="mx-auto max-w-screen-2xl px-4 md:px-8">
                <div className="mb-4 md:mb-4">
                    <h2 className="mb-4 text-left text-xl font-bold text-gray-800 md:mb-6 lg:text-2xl">
                        週間天気予報{' '}
                    </h2>
                </div>
                <div className="relative overflow-x-auto">
                    <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <tbody>
                            <tr className="bg-white dark:bg-gray-800">
                                {dailyWeather.length > 0 &&
                                    dailyWeather.map((data, index) => (
                                        <DailyWeatherTable
                                            key={index}
                                            icon={data.weather.icon}
                                            city_name={data.city_name}
                                            weather_time={
                                                data.weather.weather_time
                                            }
                                            temperature={
                                                data.weather.temperature
                                            }
                                            temp_max={data.weather.temp_max}
                                            temp_min={data.weather.temp_min}
                                            humidity={data.weather.humidity}
                                            feels_like={data.weather.feels_like}
                                            main={data.weather.main}
                                            description={
                                                data.weather.description
                                            }
                                            pop={data.weather.pop}
                                        />
                                    ))}
                            </tr>
                        </tbody>
                    </table>
                </div>
                {/* {pastWeather.length > 0 &&
                    pastWeather.map((data, index) => (
                        <DailyWeatherTable
                            key={index}
                            icon={data.weather.icon}
                            city_name={data.city_name}
                            weather_time={data.weather.weather_time}
                            temperature={data.weather.temperature}
                            temp_max={data.weather.temp_max}
                            temp_min={data.weather.temp_min}
                            humidity={data.weather.humidity}
                            feels_like={data.weather.feels_like}
                            main={data.weather.main}
                            description={data.weather.description}
                            pop={data.weather.pop}
                        />
                    ))} */}
            </div>
            {currentWeather.length === 0 && dailyWeather.length === 0 && (
                <p>Loading weather data...</p>
            )}
        </>
    )
}
export default City
