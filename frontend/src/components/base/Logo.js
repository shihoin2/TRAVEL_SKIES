import Image from 'next/image'

const Logo = (width, height) => {
    return (
        <Image
            src={`/Logo_rem.png`}
            width={width}
            height={height}
            // fill
            alt="TRAVEL SKIES Logo"
        />
    )
}
export default Logo
