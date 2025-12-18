import React from "react";
import ParagraphBlock from "@blocks/ParagraphBlock";
import UnorderedListBlock from "@blocks/UnorderedListBlock";
import ErrorBlock from "@blocks/ErrorBlock";
import QuoteBlock from "@blocks/QuoteBlock";
import ContactBlock from "@blocks/ContactBlock";
import { defaultTheme } from "@/config/theme";

const BLOCK_COMPONENTS = {
    paragraph: ParagraphBlock,
    unorderedList: UnorderedListBlock,
    quote: QuoteBlock,
    contact: ContactBlock,
    error: ErrorBlock,
};

export default function Block({ item, theme = defaultTheme }) {
    const { type, data } = item;
    const BlockComponent = BLOCK_COMPONENTS[type];

    const bgColorClass = type === "quote" ? theme.bg.secondary : "";
    const textColorClass = type === "quote" ? theme.text.light : "";

    if (!BlockComponent) return null;

    return (
        <section className={`${bgColorClass} ${textColorClass}`}>
            <div className={`max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8`}>
                <BlockComponent data={data} />
            </div>
        </section>
    );
}
