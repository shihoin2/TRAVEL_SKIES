const DailyWeatherTable = ({
    icon,
    city_name,
    weather_time,
    temperature,
    temp_max,
    temp_min,
    humidity,
    feels_like,
    main,
    description,
    pop,
}) => {
    const formatDate = dateString => {
        const date = new Date(dateString)

        const year = date.getFullYear()
        const month = date.getMonth() + 1
        const day = date.getDate()
        const hours = date.getHours().toString().padStart(2, '0')
        const minutes = date.getMinutes().toString().padStart(2, '0')
        return `${month}/${day}`
    }
    return (
        <>
            <th
                scope="row"
                className="px-6 py-4 font-medium text-gray-900 whitespace-pre-line dark:text-white">
                <>
                    <div>
                        <div className="w-full max-w-sm p-1 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div className="flex items-center justify-center">
                                <h5 className="text-xl tracking-tight text-gray-900 ">
                                    {formatDate(weather_time)}
                                </h5>
                            </div>

                            <div className="flex items-center justify-center size-20">
                                <img
                                    src={`https://openweathermap.org/img/wn/${icon}@2x.png`}
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
                                        {pop.toLocaleString('ja-JP', {
                                            style: 'percent',
                                        })}
                                    </p>
                                </div>
                            </div>
                            {/* </a> */}
                        </div>
                    </div>
                </>
            </th>
        </>
    )
}

export default DailyWeatherTable
