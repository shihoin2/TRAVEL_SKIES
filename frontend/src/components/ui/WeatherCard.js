'use client'

import axios from 'axios'
import { useState, useEffect } from 'react'
import { useParams } from 'next/navigation'
import prefectures from '@/lib/prefectures'
import cityPositions from '@/lib/cityPosition'
import Link from 'next/link'

const WeatherCard = ({
    weather_icon,
    city_name,
    weather_time,
    temperature,
    temp_max,
    temp_min,
    humidity,
    feels_like,
    main,
    description,
    decodedPrefecture,
}) => {
    const position = cityPositions[city_name]
    const formatDate = dateString => {
        const date = new Date(dateString)

        const year = date.getFullYear()
        const month = date.getMonth() + 1
        const day = date.getDate()
        const hours = date.getHours().toString().padStart(2, '0')
        const minutes = date.getMinutes().toString().padStart(2, '0')
        return `${year}/${month}/${day} ${hours}:${minutes}`
    }

    return (
        <>
            <div
                className="absolute"
                style={{
                    top: position.top,
                    left: position.left,
                    transform: 'translate(-50%, -50%)',
                }}>
                <div className="w-full max-w-sm p-1 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <Link href={`/${decodedPrefecture}/${city_name}`}>
                        {/* <a href="/{city_name}"> */}
                        <div className="flex items-center justify-center">
                            <h5 className="text-xl tracking-tight text-gray-900 ">
                                {city_name}
                            </h5>
                        </div>

                        <div className="flex items-center justify-center size-20">
                            <img
                                src={`https://openweathermap.org/img/wn/${weather_icon}@2x.png`}
                                alt="weather_icon"
                            />
                        </div>

                        <div className="">
                            <div className="flex items-center justify-center">
                                <span className="text-xl font-bold text-red-600">
                                    {Math.floor(temp_max)}
                                </span>
                                <span className="text-xl font-bold text-gray-900 ">
                                    /
                                </span>
                                <span className="text-xl font-bold text-blue-600 ">
                                    {Math.floor(temp_min)}
                                </span>
                            </div>
                            <div className="flex items-center justify-center">
                                <p className="text-xl text-gray-900 ">
                                    {humidity}%
                                </p>
                            </div>
                        </div>
                        {/* </a> */}
                    </Link>
                </div>
            </div>
        </>
    )
}

export default WeatherCard
