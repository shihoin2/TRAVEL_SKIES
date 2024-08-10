'use client'
import axios from 'axios'
import Link from 'next/link'
import { useState, useEffect } from 'react'

const Home = () => {
    const [regions, setRegions] = useState({})
    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(
                    `http://localhost/api/travel_skies/get_prefecture`,
                )
                console.log(response.data)
                setRegions(response.data)
            } catch (error) {
                console.error('データが取得できませんでした', error)
            }
        }
        fetchData()
    }, [])

    return (
        <div>
            {Object.entries(regions).map(([region, prefectures]) => (
                <div key={region}>
                    <div className="flex flex-col">
                        <div className="-m-1.5 overflow-x-auto">
                            <div className="p-1.5 min-w-full inline-block align-middle">
                                <div className="border rounded-lg shadow overflow-hidden dark:border-neutral-700 dark:shadow-gray-900">
                                    <table className="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                        <tbody className="divide-y divide-gray-200 dark:divide-neutral-700">
                                            <tr>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium w-1/5 text-gray-800 dark:text-neutral-200">
                                                    {region}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-left text-gray-800 dark:text-neutral-200">
                                                    <ul className="flex space-x-5">
                                                        {prefectures.map(
                                                            prefecture => (
                                                                <li
                                                                    key={
                                                                        prefecture
                                                                    }>
                                                                    <Link
                                                                        href={`/${prefecture}`}>
                                                                        {
                                                                            prefecture
                                                                        }
                                                                    </Link>
                                                                </li>
                                                            ),
                                                        )}
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    )
}

export default Home
