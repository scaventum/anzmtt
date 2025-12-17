import React from "react";
import ParagraphBlock from "@blocks/ParagraphBlock";
import UnorderedListBlock from "@blocks/UnorderedListBlock";

const BLOCK_COMPONENTS = {
    paragraph: ParagraphBlock,
    unorderedList: UnorderedListBlock,
};

export default function Block({ item }) {
    const { type, data } = item;
    const BlockComponent = BLOCK_COMPONENTS[type];

    if (!BlockComponent) return null;

    return (
        <div className="py-4">
            <BlockComponent data={data} />
        </div>
    );
}
