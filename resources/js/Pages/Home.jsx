import React from "react";
import { Head, Link } from "@inertiajs/react";

export default function Home({ title }) {
    return (
        <div>
            <Head title={title} />
            <h1>{title}</h1>
            <Link href="/about">About</Link>
        </div>
    );
}
