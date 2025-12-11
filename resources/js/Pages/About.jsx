import React from "react";
import { Head, Link } from "@inertiajs/react";

export default function About({ title }) {
    return (
        <div>
            <Head title={title} />
            <h1>{title}</h1>
            <Link href="/">Home</Link>
        </div>
    );
}
