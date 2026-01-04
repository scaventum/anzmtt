import React, { useState } from "react";
import { defaultTheme } from "@/config/theme";

export default function AccordionBlock({ data, theme = defaultTheme }) {
    if (!data) return null;

    const { questions } = data;
    const [openIndex, setOpenIndex] = useState(null);

    const toggle = (index) => setOpenIndex(openIndex === index ? null : index);

    return (
        <div className="space-y-4">
            {Array.isArray(questions) &&
                questions.map((item, index) => (
                    <div
                        key={index}
                        className="rounded-lg shadow-md overflow-hidden"
                    >
                        {/* Question button */}
                        <button
                            onClick={() => toggle(index)}
                            className={`w-full flex justify-between items-start px-4 py-4 font-medium focus:outline-none ${theme.bg.primary} ${theme.text.light} hover:opacity-90 rounded-t-lg min-h-[3rem]`}
                        >
                            {/* Question text */}
                            <div className="flex-1 text-left break-words">
                                {item.question}
                            </div>

                            {/* Chevron */}
                            <div className="flex-shrink-0 ml-2">
                                <svg
                                    className={`w-5 h-5 transform transition-transform duration-300 ${
                                        openIndex === index ? "rotate-180" : ""
                                    }`}
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </div>
                        </button>

                        {/* Answer */}
                        {openIndex === index && (
                            <div className="p-4 bg-gray-50 text-gray-800">
                                {item.answer}
                            </div>
                        )}
                    </div>
                ))}
        </div>
    );
}
