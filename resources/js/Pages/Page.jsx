import React from "react";
import { Head } from "@inertiajs/react";
import Navigation from "@components/Navigation";

export default function Page({ meta, data, navigationItems }) {
    return (
        <div>
            <Head title={meta.title} />
            <Navigation menu={navigationItems} />
            <h1>{data.title}</h1>
        </div>
    );
}
