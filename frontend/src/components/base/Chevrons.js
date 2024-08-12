'use client'
import axios from 'axios'
import { useState } from 'react'
import { usePathname } from 'next/navigation'

const Chevrons = () => {
    const pathName = usePathname()
    const decodeParam = param => decodeURIComponent(param)

    const url = `http://localhost:3000/${pathName}`
    const parsedUrl = new URL(url)
    const pathSegments = parsedUrl.pathname.split('/').filter(Boolean) // 空の要素を削除
    return (
        <>
            <div className="bg-white pb-6 sm:pb-8 lg:pb-12">
                {/* banner - start */}
                <div className="relative flex flex-wrap bg-[#0d71e7] px-4 py-3 sm:flex-nowrap sm:items-left sm:justify-left sm:gap-3 sm:pr-8 md:px-8">
                    <div className="order-1 mb-2 inline-block w-11/12 max-w-screen-sm text-sm text-white sm:order-none sm:mb-0 sm:w-auto md:text-base">
                        <ol className="flex items-center whitespace-nowrap">
                            <li>
                                <a
                                    className={`flex items-center text-sm text-gray-800 `}
                                    href={`/`}>
                                    Home
                                    <svg
                                        className="shrink-0 mx-2 size-4 text-gray-800"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width={24}
                                        height={24}
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        strokeWidth={2}
                                        strokeLinecap="round"
                                        strokeLinejoin="round">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </a>
                            </li>
                            {pathSegments.map((segment, index) => (
                                <li
                                    key={index}
                                    className="inline-flex items-center">
                                    <a
                                        className={`flex items-center text-sm text-gray-800 ${index === pathSegments.length - 1 ? ' text-white font-semibold truncate dark:text-neutral-200' : ''}`}
                                        href={`/${pathSegments.slice(0, index + 1).join('/')}`}>
                                        {decodeParam(segment)}
                                        {index < pathSegments.length - 1 && (
                                            <svg
                                                className="shrink-0 mx-2 size-4 text-gray-800"
                                                xmlns="http://www.w3.org/2000/svg"
                                                width={24}
                                                height={24}
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                strokeWidth={2}
                                                strokeLinecap="round"
                                                strokeLinejoin="round">
                                                <path d="m9 18 6-6-6-6" />
                                            </svg>
                                        )}
                                    </a>
                                </li>
                            ))}
                        </ol>
                    </div>
                </div>
                {/* banner - end */}
            </div>
        </>
    )
}
export default Chevrons
