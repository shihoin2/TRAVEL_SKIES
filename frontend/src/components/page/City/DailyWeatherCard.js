const DailyWeatherCard = ({
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
    return (
        <>
            {/* question - start */}
            <div className="rounded-lg bg-gray-100 p-5">
                <p className="pb-2">{weather_time}</p>
                <div className="mb-4 flex items-center justify-left gap-4 border-b pb-4">
                    <span className="inline-flex size-20 shrink-0 items-center justify-center rounded-full bg-gray-300 text-gray-500">
                        <img
                            src={`https://openweathermap.org/img/wn/${icon}@2x.png`}
                            alt="weather_icon"
                        />
                    </span>
                    <div className="flex-col">
                        <p className="font-semibold sm:text-lg md:text-xl">
                            {description}
                        </p>
                        <p className="flex items-center justify-center text-xl font-bold gap-1">
                            <span className=" text-red-600">
                                {Math.floor(temp_max)}℃
                            </span>
                            <span className=" text-gray-900 ">/</span>
                            <span className=" text-blue-600 ">
                                {Math.floor(temp_min)}℃
                            </span>
                        </p>
                    </div>
                </div>
                <p className="">
                    降水確率
                    {pop.toLocaleString('ja-JP', {
                        style: 'percent',
                    })}
                </p>
            </div>
            {/* question - end */}
        </>
    )
}
export default DailyWeatherCard
