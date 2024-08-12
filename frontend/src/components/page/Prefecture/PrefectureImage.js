'use client'

import axios from 'axios'
import { useState, useEffect } from 'react'
import { useParams } from 'next/navigation'
import prefectures from '@/lib/prefectures'
import WeatherCard from '@/components/ui/WeatherCard'

const PrefectureImage = ({ decodedPrefecture, weather }) => {
    const imagePath = prefectures[decodedPrefecture]

    return (
        <>
            {/* <div>
                <h1>{decodedPrefecture}</h1>
                <img src={imagePath} alt={`${decodedPrefecture}の画像`} />
            </div> */}
            <div className="bg-white py-6 sm:py-8 lg:py-12">
                {/* <div className="relative bg-white py-6 sm:py-8 lg:py-12"> */}
                <div className="mx-auto max-w-screen-md px-4 md:px-8">
                    <div className="relative size-full mb-6 overflow-hidden rounded-lg  md:mb-8">
                        <img
                            src={imagePath}
                            loading="lazy"
                            alt={`${decodedPrefecture}の画像`}
                            className="h-full w-full object-cover object-center"
                        />
                        {weather.map((data, index) => (
                            <WeatherCard
                                key={index}
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
                                decodedPrefecture={decodedPrefecture}
                            />
                        ))}
                    </div>
                </div>
            </div>
        </>
    )
}

export default PrefectureImage
