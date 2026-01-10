import React from "react";
import { MapPin, Calendar, Clock, DollarSign } from "lucide-react";

import { defaultTheme } from "@/config/theme";

export default function Conference({ conference, t = defaultTheme }) {
    if (!conference) return null;

    const formatDate = (date) => {
        if (!date) return null;

        return new Intl.DateTimeFormat("en-GB", {
            day: "numeric",
            month: "short",
            year: "numeric",
        }).format(new Date(date));
    };

    const formatTime = (time) => {
        if (!time) return null;

        // Combine with a dummy date so Date() can parse it
        const date = new Date(`1970-01-01T${time}`);

        return new Intl.DateTimeFormat("en-US", {
            hour: "numeric",
            minute: "2-digit",
            hour12: true,
        }).format(date);
    };

    return (
        <section
            className={`
                conference
                max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-10 lg:py-16
            `}
        >
            <div
                className={`
                    rounded-2xl
                    shadow-sm
                    border
                    ${t.bg.neutral}
                    ${t.text.default}
                    p-6 sm:p-8 lg:p-12
                `}
            >
                {/* Header */}
                <header className="mb-8">
                    <h2
                        className={`
                            text-3xl sm:text-4xl lg:text-5xl
                            font-bold
                            ${t.text.primary}
                            ${t.fontFamily.heading}
                            mb-3
                        `}
                    >
                        {conference.full_name}
                    </h2>

                    <div
                        className={`
                            h-1 w-20
                            rounded
                            ${t.bg.primary}
                        `}
                    />
                </header>

                {/* Meta grid */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    {conference.location && (
                        <MetaItem icon={MapPin} label="Location">
                            {conference.location}
                        </MetaItem>
                    )}

                    {(conference.date_from || conference.date_to) && (
                        <MetaItem icon={Calendar} label="Date">
                            {formatDate(conference.date_from)}
                            {conference.date_to &&
                                ` – ${formatDate(conference.date_to)}`}
                        </MetaItem>
                    )}

                    {(conference.time_from || conference.time_to) && (
                        <MetaItem icon={Clock} label="Time">
                            {formatTime(conference.time_from)}
                            {conference.time_to &&
                                ` – ${formatTime(conference.time_to)}`}
                        </MetaItem>
                    )}

                    {conference.cost && (
                        <MetaItem icon={DollarSign} label="Cost">
                            {conference.cost}
                        </MetaItem>
                    )}
                </div>

                {/* Downloadable file */}
                {conference.downloadables && (
                    <div className="my-4">
                        <a
                            href={`/storage/${conference.downloadables}`}
                            download
                            className={`
                                inline-flex items-center gap-1
                                text-base font-medium
                                ${t.text.primary}
                                underline
                                underline-offset-4
                                hover:no-underline
                                transition
                                focus:outline-none focus:ring-2
                                ${t.focus.primary}
                            `}
                        >
                            Download informations
                        </a>
                    </div>
                )}

                {/* Information */}
                {conference.information && (
                    <div
                        className={`
                            max-w-none
                            mb-10
                            ${t.fontFamily.body}
                            rich
                        `}
                        dangerouslySetInnerHTML={{
                            __html: conference.information,
                        }}
                    />
                )}

                {/* CTA */}
                {conference.call_for_abstract_link && (
                    <div className="flex gap-2">
                        <a
                            href={conference.call_for_abstract_link}
                            target="_blank"
                            rel="noopener noreferrer"
                            className={`
                                inline-flex items-center
                                px-8 py-4
                                rounded-lg
                                text-lg font-semibold
                                ${t.text.light}
                                ${t.bg.primary}
                                ${t.bg.hover}
                                transition
                                focus:outline-none focus:ring-2
                                ${t.focus.primary}
                            `}
                        >
                            Call for abstract
                        </a>
                        <a
                            href={conference.registration_link}
                            target="_blank"
                            rel="noopener noreferrer"
                            className={`
                                inline-flex items-center
                                px-8 py-4
                                rounded-lg
                                text-lg font-semibold
                                ${t.text.light}
                                ${t.bg.primary}
                                ${t.bg.hover}
                                transition
                                focus:outline-none focus:ring-2
                                ${t.focus.primary}
                            `}
                        >
                            Register here
                        </a>
                    </div>
                )}
            </div>
        </section>
    );
}

/**
 * Meta item sub-component
 */
function MetaItem({ icon: Icon, label, children }) {
    const t = defaultTheme;

    return (
        <div className="flex items-start gap-3">
            <Icon className="h-6 w-6 text-emerald-700" />
            <div>
                <span className="text-sm font-semibold text-gray-600">
                    {label}
                </span>
                <p className="text-base text-gray-800">{children}</p>
            </div>
        </div>
    );
}
